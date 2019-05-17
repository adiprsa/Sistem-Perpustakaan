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
				<td>Tipe Member</td>
				<td>
					<select name='tipe_member_id' class='form-control'>
						<option value=''> Pilih Tipe Member </option>
						<?php
						foreach($opsi_tipe_member->result() as $aa => $bb){
							?>
							<option value='<?=$bb->tipe_member_id?>' <?=(isset($row->tipe_member_id) AND $row->tipe_member_id==$bb->tipe_member_id) ? 'selected' : ''?> > <?=$bb->nama_tipe_member?> </option>
							<?php
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Tipe Kolasi</td>
				<td>
					<select name='tipe_kolasi_id' class='form-control'>
						<option value=''> Pilih Tipe kolasi </option>
						<?php
						foreach($opsi_tipe_kolasi->result() as $aa => $bb){
							?>
							<option value='<?=$bb->tipe_kolasi_id?>' <?=(isset($row->tipe_kolasi_id) AND $row->tipe_kolasi_id==$bb->tipe_kolasi_id) ? 'selected' : ''?> > <?=$bb->nama_tipe_kolasi?> </option>
							<?php
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Limit Peminjaman</td>
				<td>
					<input placeholder='Limit Peminjaman' type='number' name='limit_pinjam' value='<?=isset($row->limit_pinjam) ? $row->limit_pinjam : ''?>' class='form-control'>
				</td>
			</tr>
			<tr>
				<td>Periode Peminjaman</td>
				<td>
					<input placeholder='Periode Peminjaman' type='number' name='periode_pinjam' value='<?=isset($row->periode_pinjam) ? $row->periode_pinjam : ''?>' class='form-control'>
				</td>
			</tr>
			<tr>
				<td>Limit Peminjaman Ulang</td>
				<td>
					<input placeholder='Limit Peminjaman Ulang' type='number' name='limit_pinjam_ulang' value='<?=isset($row->limit_pinjam_ulang) ? $row->limit_pinjam_ulang : ''?>' class='form-control'>
				</td>
			</tr>
			<tr>
				<td>Bisa Melakukan Pinjaman Tiap Hari</td>
				<td>
					<select name='bisa_tiap_hari' class='form-control'>
						<option value=''> Pilih Kondisi</option>
						<option value='0' <?=(isset($row->tipe_kolasi_id) AND $row->tipe_kolasi_id==0) ? 'selected' : ''?>> Tidak</option>
						<option value='1' <?=(isset($row->tipe_kolasi_id) AND $row->tipe_kolasi_id==1) ? 'selected' : ''?>> Ya</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Masa Tenggang</td>
				<td>
					<input placeholder='Masa Tenggang' type='number' name='masa_tenggang' value='<?=isset($row->masa_tenggang) ? $row->masa_tenggang : ''?>' class='form-control'>
				</td>
			</tr>
			
		  </table>
        </div>
        <div class="modal-footer">
		  <input type='hidden' name='ref' value='<?=isset($row->tipe_kolasi_id) ? md5($row->tipe_kolasi_id) : '0'?>'>
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
        	url: "<?=site_url()?>pengaturan/aturan_pinjam/simpan_aturan",
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
