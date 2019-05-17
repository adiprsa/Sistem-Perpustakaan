<script src="<?=base_url('assets/')?>/datepicker/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="<?=base_url('assets/datepicker')?>/datepicker.css">
<script src="<?=base_url('assets/select2')?>/select2.min.js"></script>
<link rel="stylesheet" href="<?=base_url('assets/select2')?>/select2.min.css">
<script src="<?=base_url('assets/')?>/mce/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<script>
 $( function() {
	$( ".datepicker" ).datepicker({
				dateFormat: "dd-mm-yy",
				beforeShow: function() {
						setTimeout(function(){
							$('.ui-datepicker').css('z-index', 99999999999999);
						}, 0);
					}
			});
  } );
  </script>
  <style>
  .datepicker {
    z-index: 100000;
}
.datepicker2 {
    z-index: 100000;
}
  </style>

<div class='container'>
<div class="modal-dialog modal-lg">
		<div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Form Penerbit</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
		<form id='xyz'>
        <div class="modal-body">
		<?php
		//print_r($row);
		?>
          <table border='0' width='100%'>
			<tr>
				<td><button type='button' class='btn btn-success dltemplate'>Unduh Template</button></td>
				<td><input type='file' name='import' class='form-control'></td>
			</tr>
		  </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-info" id='simpan'>Simpan</button>
        </div>
		</form>
		<script>
	$(document).ready(function (e) {
	$("#xyz").on('submit',(function(e) {
		$("#modal_loader").show();
		e.preventDefault();
		$.ajax({
        	url: "<?=site_url()?>pengaturan/penerbit/import_penerbit",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			dataType: 'json',
			processData:false,
			success: function(respon){
				if (respon.status == 'berhasil') {
                            alert(respon.alert);
							window.location.href = respon.link;
                        } else {
                            alert(respon.alert);
							$("#modal_loader").hide();
                        }
				},
		  	error: function() 
	    	{
				alert('Gagal simpan data');
				$("#modal_loader").hide();
	    	}	        
	   });
	}));
	});
	</script>
      </div>
      </div>
      </div>
	  <script>
	$(document).on('click','.dltemplate',function(){
			//alert ($(this).attr('id'));
			location.href = '<?=base_url()?>assets/template_penerbit.xls';
	});

	</script>
	<div id="modal_loader" class="modal" data-width="600">
		<div class="loader"></div>
	<style>
#modal_loader {
  position: absolute;
  left: 50%;
  top: 50%;
  z-index: 1;
  width: 150px;
  height: 150px;
  margin: -75px 0 0 -75px;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
	