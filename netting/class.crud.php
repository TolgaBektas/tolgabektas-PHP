<?php
//session burda başlatmadık headerda başlattıktan sonra bu dosyayı ekledik ve burdaki sessionlar çalıştı
require_once 'dbconfig.php';
require_once 'plugins/PHPMailer/src/Exception.php';
require_once 'plugins/PHPMailer/src/PHPMailer.php';
require_once 'plugins/PHPMailer/src/SMTP.php';
class crud
{
	private $db;
	private $dbhost = DBHOST;
	private $dbuser = DBUSER;
	private $dbpass = DBPASS;
	private $dbname = DBNAME;
	//Sınıf oluşturulduğu an bağlantı cümlesi oluçturulacak
	function __construct()
	{
		try {
			$this->db = new PDO("mysql:host=" . $this->dbhost . ";dbname=" . $this->dbname . ";charset=utf8", $this->dbuser, $this->dbpass);
		} catch (Exception $e) {
			die("Hata alındı: " . $e->getMessage());
		}
	}

	function adminsLogin($admins_username, $admins_password, $remember_me = null)
	{
		try {
			$stmt = $this->db->prepare("SELECT * FROM admins WHERE admins_username=? AND admins_password=?");

			if (isset($_COOKIE['adminsLogin'])) {
				$stmt->execute([$admins_username, md5(openssl_decrypt($admins_password, "AES-128-ECB", "admins_unlock"))]);
			} else {
				$stmt->execute([$admins_username, md5($admins_password)]);
			}
			if ($stmt->rowCount() != 0) {
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				if ($row['admins_status'] == 0) {
					return ['status' => FALSE];
					exit;
				}
				$_SESSION["admins"] = [
					"admins_username" => $admins_username,
					"admins_namelastname" => $row['admins_namelastname']
				];
				if (!empty($remember_me) && empty($_COOKIE['adminsLogin'])) {
					$admins = [
						"admins_username" => $admins_username,
						"admins_password" => openssl_encrypt($admins_password, "AES-128-ECB", "admins_unlock")
					];
					setcookie("adminsLogin", json_encode($admins), strtotime("+30 day"), "/");
				} else if (empty($remember_me)) {
					setcookie("adminsLogin", json_encode($admins), strtotime("-30 day"), "/");
				}
				return ['status' => TRUE];
			} else {
				return ['status' => FALSE];
			}
		} catch (Exception $e) {
			return ['status' => FALSE, 'error' => $e->getMessage()];
		}
	}

	function adminsInsert($admins_namelastname, $admins_username, $admins_password, $admins_mail, $admins_status)
	{
		try {
			$stmt = $this->db->prepare("INSERT INTO admins SET admins_namelastname=?, admins_username=?, admins_password=?, admins_mail=?,admins_status=?");
			$stmt->execute([$admins_namelastname, $admins_username, md5($admins_password), $admins_mail, $admins_status]);
			return ['status' => TRUE];
		} catch (Exception $e) {
			return ['status' => FALSE, 'error' => $e->getMessage()];
		}
	}

	//bu fonksiyon prepare methodundaki sutun_adi=? işlemini gerçekleştirir
	function addValue($args)
	{
		$values = implode(',', array_map(function ($item) {
			return $item . "=?";
		}, array_keys($args)));
		return $values;
	}

	function imageUpload($name, $size, $tmp_name, $dir, $delete_file = null, $th = null)
	{
		try {
			$izinli_uzantilar = [
				'jpg',
				'png',
				'jpge',
				'jpeg'
			];

			if ($th == true) { // thumbnail boş değilse
				$ext = pathinfo($name)['extension'];
				if (in_array($ext, $izinli_uzantilar) === false) {
					return ['code' => 1];
				}
				if ($size > 314572) {
					//max 0,3 mb
					return ['code' => 2];
				}
				$name_new = "/" . uniqid() . "_th_" . $name;

				if (!@move_uploaded_file($tmp_name, "$dir/$name_new")) {
					throw new Exception("Dosya yüklenirken hata oluştu...");
				}
				if (!empty($delete_file)) {
					unlink($delete_file);
				}
				return $dir . $name_new;
			} else if ($th == false) {
				$ext = strtolower(substr($name, strpos($name, ".") + 1));
				if (in_array($ext, $izinli_uzantilar) === false) {
					return ['code' => 1];
				}
				if ($size > 1048576) {
					//max 1 mb
					return ['code' => 2];
				}
				$name_new = "/" . uniqid() . $name;
				if (!@move_uploaded_file($tmp_name, "$dir/$name_new")) {
					throw new Exception("Dosya yüklenirken hata oluştu...");
				}
				if (!empty($delete_file)) {
					unlink($delete_file);
				}
				return $dir . $name_new;
			}
		} catch (Exception $e) {
			return ['status' => 0, 'error' => $e->getMessage()];
		}
	}

	function read($table, $options = [])
	{
		try {
			if (isset($options['columns_name']) && empty($options['limit'])) {
				$stmt = $this->db->prepare("SELECT * FROM $table ORDER BY {$options['columns_name']} {$options['columns_sort']}");
			} else if (isset($options['columns_name']) && isset($options['limit'])) {
				$stmt = $this->db->prepare("SELECT * FROM $table ORDER BY {$options['columns_name']} {$options['columns_sort']} limit {$options['limit']}");
			} else {
				$stmt = $this->db->prepare("SELECT * FROM $table");
			}
			$stmt->execute();
			return $stmt;
		} catch (Exception $e) {
			return ['status' => FALSE, 'error' => $e->getMessage()];
		}
	}

	function wread($table, $columns, $values)
	{
		try {
			$stmt = $this->db->prepare("SELECT * FROM $table WHERE $columns=?");
			$stmt->execute([htmlspecialchars($values)]);
			return $stmt;
		} catch (Exception $e) {
			return ['status' => FALSE, 'error' => $e->getMessage()];
		}
	}

	function insert($table, $values, $options = [])
	{
		try {
			if (isset($options['slug'])) {
				if (empty($values[$options['slug']])) {
					$values[$options['slug']] = $this->seo($values[$options['title']]);
				} else {
					$values[$options['slug']] = $this->seo($values[$options['slug']]);
				}
			}
			if (isset($options["file_name1"])) {
				if (!empty($_FILES[$options["file_name1"]]['name'])) {
					$name_new = $this->imageUpload(
						$_FILES[$options["file_name1"]]['name'],
						$_FILES[$options["file_name1"]]['size'],
						$_FILES[$options["file_name1"]]['tmp_name'],
						$options["dir"]
					);
					if (isset($name_new['code'])) {
						if ($name_new['code'] == 1) {
							throw new Exception("Geçersiz dosya türü girildi...");
							exit;
						} else if ($name_new['code'] == 2) {
							throw new Exception("Büyük dosya girildi...");
							exit;
						}
					}
					$values += [$options['file_name1'] => $name_new];
				}
			}
			//thumbnail bölümü
			if (isset($options["file_name1_th"])) {
				if (!empty($_FILES[$options["file_name1_th"]]['name'])) {
					$name_new = $this->imageUpload(
						$_FILES[$options["file_name1_th"]]['name'],
						$_FILES[$options["file_name1_th"]]['size'],
						$_FILES[$options["file_name1_th"]]['tmp_name'],
						$options["dir"],
						false,
						TRUE
					);
					if (isset($name_new['code'])) {
						if ($name_new['code'] == 1) {
							throw new Exception("Geçersiz dosya türü girildi...");
							exit;
						} else if ($name_new['code'] == 2) {
							throw new Exception("Büyük dosya girildi...");
							exit;
						}
					}
					$values += [$options['file_name1_th'] => $name_new];
				}
			}
			if (isset($options["file_name2"])) {
				if (!empty($_FILES[$options["file_name2"]]['name'])) {
					$name_new = $this->imageUpload(
						$_FILES[$options["file_name2"]]['name'],
						$_FILES[$options["file_name2"]]['size'],
						$_FILES[$options["file_name2"]]['tmp_name'],
						$options["dir"]
					);
					if (isset($name_new['code'])) {
						if ($name_new['code'] == 1) {
							throw new Exception("Geçersiz dosya türü girildi...");
							exit;
						} else if ($name_new['code'] == 2) {
							throw new Exception("Büyük dosya girildi...");
							exit;
						}
					}
					$values += [$options['file_name2'] => $name_new];
				}
			}
			//thumbnail bölümü
			if (isset($options["file_name2_th"])) {
				if (!empty($_FILES[$options["file_name2_th"]]['name'])) {
					$name_new = $this->imageUpload(
						$_FILES[$options["file_name2_th"]]['name'],
						$_FILES[$options["file_name2_th"]]['size'],
						$_FILES[$options["file_name2_th"]]['tmp_name'],
						$options["dir"],
						false,
						TRUE
					);
					if (isset($name_new['code'])) {
						if ($name_new['code'] == 1) {
							throw new Exception("Geçersiz dosya türü girildi...");
							exit;
						} else if ($name_new['code'] == 2) {
							throw new Exception("Büyük dosya girildi...");
							exit;
						}
					}
					$values += [$options['file_name2_th'] => $name_new];
				}
			}
			if (isset($options['password'])) {
				//eger options da password var ise md5 ile şifrele ve değiştir
				$values[$options['password']] = md5($values[$options['password']]);
			}
			if (isset($options['form_name'])) {
				unset($values[$options['form_name']]);
				//gelen buttondaki post değerini siliyoruz
			}
			$stmt = $this->db->prepare("INSERT INTO $table SET {$this->addValue($values)}");
			$stmt->execute(array_values($values)); //array_values ile sadece değerleri alma işlemini yaparız

			return ['status' => TRUE];
		} catch (Exception $e) {
			return ['status' => FALSE, 'error' => $e->getMessage()];
		}
	}
	/**
	 * @param mixed $table güncellenecek tablo adı
	 * @param mixed $values güncellenecek veriler
	 * @param array $options asfd
	 * @return true kod çalıştı
	 * @return false hata var ['error'] döner
	 */
	function update($table, $values, $options = [])
	{
		try {
			if (isset($options['slug'])) {
				if (empty($values[$options['slug']])) {
					$values[$options['slug']] = $this->seo($values[$options['title']]);
				} else {
					$values[$options['slug']] = $this->seo($values[$options['slug']]);
				}
			}
			if (!empty($_FILES[$options["file_name1"]]['name'])) {
				$name_new = $this->imageUpload(
					$_FILES[$options["file_name1"]]['name'],
					$_FILES[$options["file_name1"]]['size'],
					$_FILES[$options["file_name1"]]['tmp_name'],
					$options["dir"],
					$values[$options['delete_file1']],
					false
				);
				if (isset($name_new['code'])) {
					if ($name_new['code'] == 1) {
						throw new Exception("Geçersiz dosya türü girildi...");
						exit;
					} else if ($name_new['code'] == 2) {
						throw new Exception("Büyük dosya girildi...");
						exit;
					}
				}
				$values += [$options['file_name1'] => $name_new];
			}
			//thumbnail bölümü
			if (!empty($_FILES[$options["file_name1_th"]]['name'])) {
				$name_new = $this->imageUpload(
					$_FILES[$options["file_name1_th"]]['name'],
					$_FILES[$options["file_name1_th"]]['size'],
					$_FILES[$options["file_name1_th"]]['tmp_name'],
					$options["dir"],
					$values[$options['delete_file1_th']],
					TRUE
				);
				if (isset($name_new['code'])) {
					if ($name_new['code'] == 1) {
						throw new Exception("Geçersiz dosya türü girildi...");
						exit;
					} else if ($name_new['code'] == 2) {
						throw new Exception("Büyük dosya girildi...");
						exit;
					}
				}
				$values += [$options['file_name1_th'] => $name_new];
			}

			if (!empty($_FILES[$options["file_name2"]]['name'])) {
				$name_new = $this->imageUpload(
					$_FILES[$options["file_name2"]]['name'],
					$_FILES[$options["file_name2"]]['size'],
					$_FILES[$options["file_name2"]]['tmp_name'],
					$options["dir"],
					$values[$options['delete_file2']]
				);
				if (isset($name_new['code'])) {
					if ($name_new['code'] == 1) {
						throw new Exception("Geçersiz dosya türü girildi...");
						exit;
					} else if ($name_new['code'] == 2) {
						throw new Exception("Büyük dosya girildi...");
						exit;
					}
				}
				$values += [$options['file_name2'] => $name_new];
			}
			//thumbnail bölümü
			if (!empty($_FILES[$options["file_name2_th"]]['name'])) {
				$name_new = $this->imageUpload(
					$_FILES[$options["file_name2_th"]]['name'],
					$_FILES[$options["file_name2_th"]]['size'],
					$_FILES[$options["file_name2_th"]]['tmp_name'],
					$options["dir"],
					$values[$options['delete_file2_th']],
					TRUE
				);
				if (isset($name_new['code'])) {
					if ($name_new['code'] == 1) {
						throw new Exception("Geçersiz dosya türü girildi...");
						exit;
					} else if ($name_new['code'] == 2) {
						throw new Exception("Büyük dosya girildi...");
						exit;
					}
				}
				$values += [$options['file_name2_th'] => $name_new];
			}

			if (isset($options['password'])) {
				$values[$options['password']] = md5($values[$options['password']]);
			}

			unset($values[$options['delete_file1']]);
			unset($values[$options['delete_file2']]);
			unset($values[$options['delete_file1_th']]);
			unset($values[$options['delete_file2_th']]);
			$columns_id = $values[$options['columns']]; // sıralama da karışıklığı engellemek için bunu bir değişkene atadık ve en son ekledik WHERE koşulu için
			unset($values[$options['form_name']]); //gelen buttondaki post değerini siliyoruz
			unset($values[$options['columns']]); //colums'u ettik çünkü $values'te kalırsa VT'de  oraya ekleme yapmaya çalışır fakat VT'ye onu eklemekistemiyoruz
			$valuesExe = $values;
			$valuesExe += [$options['columns'] => $columns_id];
			$stmt = $this->db->prepare("UPDATE $table SET {$this->addValue($values)} WHERE {$options['columns']}=?");
			$stmt->execute(array_values($valuesExe)); //array_values ile sadece değerleri alma işlemini yaparız		
			return ['status' => TRUE];
		} catch (Exception $e) {
			return ['status' => FALSE, 'error' => $e->getMessage()];
		}
	}

	function delete($table, $columns, $values, $fileName1 = null, $fileName1_th = null, $fileName2 = null, $fileName2_th = null)
	{
		try {
			if (!empty($fileName1)) {
				unlink($fileName1);
			}
			if (!empty($fileName2)) {
				unlink($fileName2);
			}
			if (!empty($fileName1_th)) {
				unlink($fileName1_th);
			}
			if (!empty($fileName2_th)) {
				unlink($fileName2_th);
			}
			$stmt = $this->db->prepare("DELETE FROM $table WHERE $columns=?");
			$stmt->execute([htmlspecialchars($values)]);
			return ['status' => TRUE];
		} catch (Exception $e) {
			return ['status' => FALSE, 'error' => $e->getMessage()];
		}
	}

	function tDate($date, $options = [])
	{
		$arg = explode(" ", $date);
		$date = explode("-", $arg[0]);
		$time = $arg[1];
		if (isset($options['date'])) {
			return $date[2] . "-" . $date[1] . "-" . $date[0];
		} else if (isset($options['year'])) {
			return $date[0];
		} else if (isset($options['time'])) {
			return $time;
		} else if (isset($options['date_time'])) {
			return $date[2] . "-" . $date[1] . "-" . $date[0] . " " . $time;
		}
	}

	function seo($str, $options = array())
	{
		$str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
		$defaults = array(
			'delimiter' => '-',
			'limit' => null,
			'lowercase' => true,
			'replacements' => array(),
			'transliterate' => true
		);
		$options = array_merge($defaults, $options);
		$char_map = array(
			// Latin
			'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
			'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
			'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
			'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
			'ß' => 'ss',
			'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
			'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
			'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
			'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
			'ÿ' => 'y',
			// Latin symbols
			'©' => '(c)',
			// Greek
			'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
			'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
			'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
			'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
			'Ϋ' => 'Y',
			'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
			'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
			'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
			'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
			'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
			// Turkish
			'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
			'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
			// Russian
			'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
			'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
			'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
			'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
			'Я' => 'Ya',
			'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
			'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
			'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
			'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
			'я' => 'ya',
			// Ukrainian
			'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
			'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
			// Czech
			'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
			'Ž' => 'Z',
			'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
			'ž' => 'z',
			// Polish
			'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
			'Ż' => 'Z',
			'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
			'ż' => 'z',
			// Latvian
			'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
			'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
			'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
			'š' => 's', 'ū' => 'u', 'ž' => 'z'
		);
		$str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
		if ($options['transliterate']) {
			$str = str_replace(array_keys($char_map), $char_map, $str);
		}
		$str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
		$str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
		$str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
		$str = trim($str, $options['delimiter']);
		return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
	}
	/**
	 * @param mixed $sql SQL sorgusu
	 */
	function qSql($sql)
	{
		try {
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
			return ['status' => true, 'stmt' => $stmt];
		} catch (Exception $e) {
			return ['status' => FALSE, 'error' => $e->getMessage()];
		}
	}
	/**
	 * @param mixed $ip sorgulanacak ip adresi
	 */
	public function ipSehir($ip)
	{
		$ch = curl_init('http://ip-api.com/json/' . $ip . '?lang=en');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json'
		));
		$result = curl_exec($ch);
		$data = json_decode($result);
		if (!empty($data)) {
			$ulke = $data->country;
			$sehir = $data->regionName;
			$postaKodu = $data->zip;
			return ['ulke' => $ulke, 'sehir' => $sehir, 'postaKodu' => $postaKodu];
		}
	}
	/**
	 * @param mixed $username gönderen mail adresi
	 * @param mixed $name gönderen kişinin adı
	 * @param mixed $password gönderen mailin şifresi
	 * @param mixed $reply alıcının cevaplayacağı adres
	 * @param mixed $replyname alıcının cevaplayacağı kişinin adı
	 * @param mixed $kime mailin gideceği kişi
	 * @param mixed $konu mailin konusu
	 * @param mixed $icerik mailin içeriği
	 * @param mixed $ek gönderilecek ek dosya 
	 **/
	public function teklimail($username, $name = null, $password, $reply, $replyname = null, $kime, $konu = null, $icerik, $ek = null)
	{
		$mail = new PHPMailer\PHPMailer\PHPMailer();
		try {
			$mail->setLanguage('tr');
			$mail->isSMTP();
			$mail->Host       = 'smtp.gmail.com';
			$mail->SMTPAuth   = true;
			$mail->Username   = $username;
			$mail->Password   = $password;
			$mail->SMTPSecure = 'tls';
			$mail->Port       = 587;
			$mail->CharSet = 'UTF-8';

			$mail->setFrom($username, $name);
			$mail->addAddress($kime);
			$mail->addReplyTo($reply, $replyname); //giden kişi kime geri cevap yazsın

			if ($ek) {
				//max 25 mb 
				if ($ek['size'] < 26214400) {
					$mail->addAttachment($ek['tmp_name'], $ek['name']);
				} else {
					return ['status' => false, 'error' => 'size'];
				}
			}
			$mail->isHTML(true);
			if ($konu) {
				$mail->Subject = $konu;
			}
			$mail->Body = $icerik;
			//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients'; // html desteklemeyenler için
			$mail->send();
			return ['status' => TRUE];
		} catch (Exception $e) {
			return ['status' => false, 'error' => $e->ErrorMessage];
		}
	}
	function temizle($str)
	{
		return htmlspecialchars($str);
	}
}
