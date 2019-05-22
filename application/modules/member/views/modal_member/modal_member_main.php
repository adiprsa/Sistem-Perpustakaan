<link rel="stylesheet" href="<?php echo base_url('assets/vendor/datepicker/tempusdominus-bootstrap-4.css')?>">
<?php 
	$row = $data->row();	
?>
<div class='container'>
<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Form Tambah Member</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form id='xyz'>
				<div class="modal-body">
					<table border='0' width='100%'>
						<tr>
							<td>Nomor Induk Member</td>
							<td>
								<input type='text' name='nomor_induk_member' class='form-control'
								value='<?=isset($row->nomor_induk_member) ? $row->nomor_induk_member : ''?>'
								<?=isset($row->nomor_induk_member) ? 'readonly' : ''?>>
							</td>
						</tr>
						<tr>
							<td>Tipe Member</td>
							<td>
								<select class="form-control" name="tipe_member">
									<option value="0">-- pilih --</option>
								<?php foreach ($tipe_member->result() as $tipe_member) {?>
									<option value="<?php echo $tipe_member->tipe_member_id; ?>" 
									<?= isset($row->tipe_member) ? 
									($row->tipe_member == $tipe_member->tipe_member_id ? 
									'selected' : '' ) : ''?>>
									<?php echo $tipe_member->nama_tipe_member; ?></option>
								<?php } ?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Nama Member</td>
							<td>
								<input type='text' name='nama_member' class='form-control'
								value='<?=isset($row->nama_member) ? $row->nama_member : ''?>'>
							</td>
						</tr>
						<tr>
							<td>Jenis Kelamin</td>
							<td>
								<select class="form-control" name="jenis_kelamin">
									<option value="0">-- pilih --</option>
									<option value="L" <?= isset($row->jenis_kelamin) ? 
									($row->jenis_kelamin == 'L' ? 'selected' : '' ) : ''?>>LAKI-LAKI</option>
									<option value="P" <?= isset($row->jenis_kelamin) ? 
									($row->jenis_kelamin == 'P' ? 'selected' : '' ) : ''?>>PEREMPUAN</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Tanggal Lahir</td>
							<td>
								<div class="form-group">
									<div class="input-group date" id="datetimepicker4" data-target-input="nearest">
										<input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker4" name="tanggal_lahir"
										value='<?=isset($tanggal_lahir) ? $tanggal_lahir : ''?>'>
										<div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
											<div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
										</div>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td>
								<input type='text' name='alamat' class='form-control'
								value='<?=isset($row->alamat) ? $row->alamat : ''?>'>
							</td>
						</tr>
						<tr>
							<td>E-mail</td>
							<td>
								<input type='email' name='email' class='form-control'
								value='<?=isset($row->email) ? $row->email : ''?>'>
							</td>
						</tr>
						<tr>
							<td>Fakultas</td>
							<td>
								<select class="form-control" name="fakultas" id="fakultas">
									<option>-- pilih --</option>
								<?php foreach ($fakultas->result() as $fakultas) {?>
									<option value="<?php echo $fakultas->kd_fakultas; ?>" 
									<?= isset($row->prodi) ? ($fakultas->kd_fakultas == $kd_fakultas ? 'selected' : '' ) : ''?>>
									<?php echo $fakultas->fakultas; ?></option>
								<?php } ?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Jurusan</td>
							<td>
								<select class="form-control" name="prodi" id="prodi">
									<option value="0">-- pilih --</option>
									<?php if(isset($row->prodi)) {
										foreach ($query_prodi->result() as $list_prodi) { ?>
										<option value="<?php echo $list_prodi->kd_prodi?>" 
											<?= $list_prodi->kd_prodi == $row->prodi ? 'selected' : ''?>>
											<?php echo $list_prodi->prodi; ?>
										</option>
									<?php }
									} ?>
								</select>
							</td>
						</tr>

					</table>
				</div>
				<div class="modal-footer">
				<input type='hidden' name='ref' value='<?=isset($row->member_id) ? md5($row->member_id) : '0'?>'>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-info" id='simpan'>Simpan</button>
				</div>
			</form>
		</div>
</div>
</div>
