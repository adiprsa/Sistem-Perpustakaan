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
				<td>Nama Supplier</td>
				<td>
					<input placeholder='Nama Supplier' type='text' name='nama_supplier' value='<?=isset($row->nama_supplier) ? $row->nama_supplier : ''?>' class='form-control'>
				</td>
			</tr>
			<tr>
				<td>Kontak</td>
				<td>
					<input placeholder='Kontak Supplier' type='text' name='kontak' value='<?=isset($row->kontak) ? $row->kontak : ''?>' class='form-control'>
				</td>
			</tr>
			<tr>
				<td>Alamat</td>
				<td>
					<input placeholder='Alamat Supplier' type='text' name='alamat' value='<?=isset($row->alamat) ? $row->alamat : ''?>' class='form-control'>
				</td>
			</tr>
			<tr>
				<td>Kode Pos</td>
				<td>
					<input placeholder='Kode pos Supplier' type='text' name='kode_pos' value='<?=isset($row->kode_pos) ? $row->kode_pos : ''?>' class='form-control'>
				</td>
			</tr>
			<tr>
				<td>Telephone</td>
				<td>
					<input placeholder='Telephone Supplier' type='text' name='telephone' value='<?=isset($row->telephone) ? $row->telephone : ''?>' class='form-control'>
				</td>
			</tr>
			<tr>
				<td>Fax</td>
				<td>
					<input placeholder='Fax Supplier' type='text' name='fax' value='<?=isset($row->fax) ? $row->fax : ''?>' class='form-control'>
				</td>
			</tr>
			<tr>
				<td>Akun</td>
				<td>
					<input placeholder='Akun Supplier' type='text' name='akun' value='<?=isset($row->akun) ? $row->akun : ''?>' class='form-control'>
				</td>
			</tr>
			<tr>
				<td>Email</td>
				<td>
					<input placeholder='Email Supplier' type='email' name='email' value='<?=isset($row->email) ? $row->email : ''?>' class='form-control'>
				</td>
			</tr>
		  </table>
        </div>
        <div class="modal-footer">
		  <input type='hidden' name='ref' value='<?=isset($row->supplier_id) ? md5($row->supplier_id) : '0'?>'>
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
        	url: "<?=site_url()?>Pengaturan/simpan_supplier",
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
