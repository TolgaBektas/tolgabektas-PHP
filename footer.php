</div>
</div>
</div>
<!-- Main Footer -->
<footer class="main-footer">
	<!-- To the right -->
	<div class="float-right d-none d-sm-inline">
		Tolga Bektaş

	</div>
	<!-- Default to the left -->
	<a href="index">Anasayfa</a>
</footer>
</div>
<!-- ZORUNLU TEXTAREA JS KODU START -->
<script>
	$(function () {    
		$('#summernote').summernote()

		CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
			mode: "htmlmixed",
			theme: "monokai"
		});
	})
</script>
<!-- ZORUNLU TEXTAREA JS KODU END -->
<!-- ZORUNLU TEXTAREA JS KODU START -->
<script>
	$(function () {    
		$('#summernote2').summernote()

		CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
			mode: "htmlmixed",
			theme: "monokai"
		});
	})
</script>
<!-- ZORUNLU TEXTAREA JS KODU END -->
<script>
  $(function () {
    //Add text editor
    $('#compose-textarea').summernote()
  })
</script>

<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- bs-custom-file-input -->
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>


<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- CodeMirror -->
<script src="plugins/codemirror/codemirror.js"></script>
<script src="plugins/codemirror/mode/css/css.js"></script>
<script src="plugins/codemirror/mode/xml/xml.js"></script>
<script src="plugins/codemirror/mode/htmlmixed/htmlmixed.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>



<!-- Page specific script -->
<script>
	$(function () {
		bsCustomFileInput.init();
	});

</script>


</body>
</html>
