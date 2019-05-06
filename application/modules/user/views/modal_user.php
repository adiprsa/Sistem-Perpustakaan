<?php
$row = $user->row();
?>
<script src="<?=base_url('assets/select2')?>/select2.min.js"></script>
<script src="<?=base_url('assets/')?>/mce/tinymce.min.js"></script>
<link rel="stylesheet" href="<?=base_url('assets/select2')?>/select2.min.css">
<script>tinymce.init({ selector:'textarea' });</script>
<div class='container'>
<div class="modal-dialog modal-lg">
		<div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Form User</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
		<form id='xyz'>
        <div class="modal-body">
		<?php
		//print_r($row);
		?>
          <table border='0' width='100%'>
			<tr>
				<td>Username</td>
				<td>
					<input placeholder='Username' type='text' <?=isset($row->username) ? 'readonly' : ''?> name='username' value='<?=isset($row->username) ? $row->username : ''?>' class='form-control'>
				</td>
			</tr>
			<tr>
				<td>Userlevel</td>
				<td>
					<?php
					if(isset($row->nama_level)){
						?>
					<input type='text' readonly name='userlevel' value='<?=$row->nama_level?>' class='form-control'>
					<input type='hidden' name='userlevel' value='<?=$row->userlevel?>'>
						<?php
					}else{
						?>
						<select name='userlevel' class='form-control'>						
							<option value='1'> Superadmin
						</select>						
						<?php
					}
					?>
				</td>
			</tr>
			<tr>
				<td>Password</td>
				<td>
					<input type='password' name='password1' value='' placeholder='Isi jika ingin mengganti password' class='form-control'>
				</td>
			</tr>
			<tr>
				<td>Konfirmasi Password</td>
				<td>
					<input type='password' name='password2' value='' placeholder='Isi jika ingin mengganti password' class='form-control'>
				</td>
			</tr>
			<tr>
				<td>Nama Lengkap</td>
				<td>
					<input placeholder='Nama Lengkap' type='text' name='name' value='<?=isset($row->nama_asli) ? $row->nama_asli : ''?>' class='form-control'>
				</td>
			</tr>
			<tr>
				<td>Email</td>
				<td>
					<input placeholder='Email' type='email' name='email' value='<?=isset($row->email) ? $row->email : ''?>' class='form-control'>
				</td>
			</tr>
			<tr>
				<td>Status</td>
				<td>
					<select name='status' class='form-control'>
						<option value='0' <?=(isset($row->status) AND $row->status==0) ? "selected" : ''?> >Tidak Aktif
						<option value='1' <?=(isset($row->status) AND $row->status==1) ? "selected" : ''?> >Aktif
						<option value='2' <?=(isset($row->status) AND $row->status==2) ? "selected" : ''?> >Bekukan
					</select>
					
				</td>
			</tr>
			
		  </table>
        </div>
        <div class="modal-footer">
		  <input type='hidden' name='ref' value='<?=isset($row->id) ? md5($row->id) : '0'?>'>
		  <input type='hidden' name='old_status' value='<?=isset($row->status) ? md5($row->status) : '0'?>'>
		  
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
        	url: "<?=site_url()?>/User/simpan_user",
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
	