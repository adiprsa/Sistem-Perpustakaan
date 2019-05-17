<?php
$row = $datanya->row();
?>
<script src="<?=base_url('assets/')?>/datepicker/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="<?=base_url('assets/datepicker')?>/bootstrap-datepicker.css">


<style>
  .datepicker {
    z-index: 100000;
}
</style>
<script>
$(function() {
    $('.datepicker').datepicker( {
        format: " yyyy",
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy MM',
        
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
				<td>Fakultas</td>
				<td>
					<select name='kd_fakultas' class='form-control' <?=($kd_fakultas AND $kd_fakultas != "-") ? 'disabled' : ''?>>
						<option value=''>Pilih Fakultas</option>
						<?php
						print_r($form_fakultas->result());
						foreach($form_fakultas->result() as $aa => $bb){
							if($kd_fakultas == sha1($bb->kd_fakultas)){
								$val = $bb->kd_fakultas;
							}
							?>
								<option value='<?=$bb->kd_fakultas?>' <?=($kd_fakultas AND $kd_fakultas == sha1($bb->kd_fakultas)) ? 'selected' : ''?> > <?=$bb->fakultas?></option>							
							<?php
						}
						?>
					</select>
					<?php
					if($kd_fakultas!="-"){
						?>
						<input type='hidden' name='kd_fakultas' value='<?=$val?>'>
						<?php
					}
					?>
				</td>
			</tr>
			<tr>
				<td>Kode Prodi</td>
				<td>
					<input placeholder='Kode Prodi' type='text' name='kd_prodi' <?=(isset($ref) AND $ref!="0") ? 'readonly' : ''?> value='<?=isset($row->kd_prodi) ? $row->kd_prodi : ''?>' class='form-control'>
				</td>
			</tr>
			<tr>
				<td>Nama Prodi</td>
				<td>
					<input placeholder='Nama Prodi' type='text' name='prodi' value='<?=isset($row->prodi) ? $row->prodi : ''?>' class='form-control'>
				</td>
			</tr>
		  </table>
        </div>
        <div class="modal-footer">
		  <input type='hidden' name='ref' value='<?=isset($row->kd_prodi) ? md5($row->kd_prodi) : '0'?>'>
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
        	url: "<?=site_url()?>pengaturan/prodi/simpan_prodi",
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
