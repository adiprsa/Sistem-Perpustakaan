<link rel="stylesheet" href="<?php echo base_url('assets/vendor/datepicker/tempusdominus-bootstrap-4.css')?>">
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
								<input type='text' name='nomor_induk_member' class='form-control'>
							</td>
						</tr>
						<tr>
							<td>Tipe Member</td>
							<td>
								<select class="form-control" name="tipe_member">
									<option>-- pilih --</option>
									<?php foreach ($tipe_member->result() as $row) {?>
									<option value="<?php echo $row->tipe_member_id;?>"><?php echo $row->nama_tipe_member;?></option>
									<?php }?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Nama Member</td>
							<td>
								<input type='text' name='nama_member' class='form-control'>
							</td>
						</tr>
						<tr>
							<td>Jenis Kelamin</td>
							<td>
								<select class="form-control" name="jenis_kelamin">
									<option value="0">-- pilih --</option>
									<option value="L">LAKI-LAKI</option>
									<option value="P">PEREMPUAN</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Tanggal Lahir</td>
							<td>
								<div class="form-group">
									<div class="input-group date" id="dp_tgl_lahir" data-target-input="nearest">
										<input type="text" class="form-control datetimepicker-input" data-target="#dp_tgl_lahir" name="tanggal_lahir">
										<div class="input-group-append" data-target="#dp_tgl_lahir" data-toggle="datetimepicker">
											<div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
										</div>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td>
								<input type='text' name='alamat' class='form-control'>
							</td>
						</tr>
						<tr>
							<td>E-mail</td>
							<td>
								<input type='email' name='email' class='form-control'>
							</td>
						</tr>
						<tr>
							<td>Fakultas</td>
							<td>
								<select class="form-control" name="fakultas" id="fakultas">
									<option>-- pilih --</option>
									<?php foreach ($fakultas->result() as $row) {?>
									<option value="<?php echo $row->kd_fakultas;?>"><?php echo $row->fakultas;?></option>
									<?php }?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Jurusan</td>
							<td>
								<select class="form-control" name="prodi" id="prodi">
									<option value="0">-- pilih --</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Tanggal Register</td>
							<td>
								<div class="form-group">
									<div class="input-group date" id="dp_tgl_register" data-target-input="nearest">
										<input type="text" class="form-control datetimepicker-input" data-target="#dp_tgl_register" name="tanggal_register">
										<div class="input-group-append" data-target="#dp_tgl_register" data-toggle="datetimepicker">
											<div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
										</div>
									</div>
								</div>
							</td>
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-info" id='simpan'>Simpan</button>
				</div>
			</form>
		</div>
</div>
</div>
