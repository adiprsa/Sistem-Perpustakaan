<?php
$row = $datanya->row();
?>
<script src="<?=base_url('assets')?>/datepicker/jquery.datetimepicker.full.js"></script>
<link rel="stylesheet" href="<?=base_url('assets/datepicker')?>/jquery.datetimepicker.css">


<style>
  .datepicker {
    z-index: 100000;
}
</style>
<script>
$(function() {
    $('.datepicker').datetimepicker( {
        datepicker:false,
		step:1,
		timepickerScrollbar:true,
		format:'H:i:00'
        
    });
});
</script>

<div class='container'>
<div class="modal-dialog modal-lg">
		<div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Form <?=$title?></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
		<form id='xyz'>
        <div class="modal-body">
		<?php
		//print_r($row);
		?>
          <table border='0' width='100%'>
			<tr>
				<td>Frekuensi</td>
				<td>
					<input placeholder='Frekuensi' type='text' name='frekuensi' value='<?=isset($row->frekuensi) ? $row->frekuensi : ''?>' class='form-control'>
				</td>
			</tr>
			<tr>
				<td>Bahasa</td>
				<td>
					<input placeholder='Bahasa' type='text' name='bahasa' value='<?=isset($row->bahasa) ? $row->bahasa : ''?>' class='form-control'>
				</td>
			</tr>
			<tr>
				<td>Waktu</td>
				<td>
					<input placeholder='Waktu' type='text' readonly name='waktu' value='<?=isset($row->waktu) ? $row->waktu : ''?>' class='form-control datepicker'>
				</td>
			</tr>
			<tr>
				<td>Waktu Unit</td>
				<td>
					<input placeholder='Waktu Unit' type='text' readonly name='waktu_unit' value='<?=isset($row->waktu_unit) ? $row->waktu_unit : ''?>' class='form-control datepicker'>
				</td>
			</tr>
		  </table>
        </div>
        <div class="modal-footer">
		  <input type='hidden' name='ref' value='<?=isset($row->frekuensi_id) ? md5($row->frekuensi_id) : '0'?>'>
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
        	url: "<?=site_url()?>pengaturan/frekuensi/simpan_frekuensi",
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
