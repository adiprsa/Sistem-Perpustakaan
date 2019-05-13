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
				<td>Nama Pengarang</td>
				<td>
					<input placeholder='Nama Pengarang' type='text' name='nama_pengarang' value='<?=isset($row->nama_pengarang) ? $row->nama_pengarang : ''?>' class='form-control'>
				</td>
			</tr>
			<tr>
				<td>Tahun Pengarang</td>
				<td>
					<input placeholder='Tahun Pengarang' type='year' name='tahun_pengarang' value='<?=isset($row->tahun_pengarang) ? $row->tahun_pengarang : date('Y')?>' readonly class='form-control datepicker'>
				</td>
			</tr>
			<tr>
				<td>Tipe Pengarang</td>
				<td>
					<select name='tipe_pengarang' class='form-control'>
						<option value='0'> Pilih Tipe Pengarang </option>
						<?php
						foreach($tipe_pengarang->result() as $aa=>$bb){
							?>
						<option value='<?=$bb->id?>' <?=(isset($row->tipe_pengarang) AND $row->tipe_pengarang == $bb->id)? 'selected' : ''?>> <?=$bb->tipe?> </option>
							<?php
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Kata Kunci</td>
				<td>
					<input placeholder='Kata Kunci' type='text' name='kata_kunci' value='<?=isset($row->kata_kunci) ? $row->kata_kunci : ''?>' class='form-control'>					
				</td>
			</tr>
			
		  </table>
        </div>
        <div class="modal-footer">
		  <input type='hidden' name='ref' value='<?=isset($row->pengarang_id) ? md5($row->pengarang_id) : '0'?>'>
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
        	url: "<?=site_url()?>Pengaturan/simpan_pengarang",
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
		$(document).on('change','#jenis',function(){
						$('#asw').load("<?=site_url('News/opsi_sasaran')?>/" + $('#jenis').val() + "/",function(){
							 $("#asw").html(data);
						});
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
