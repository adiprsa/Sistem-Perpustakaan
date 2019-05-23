<?php $row = $data->row();?>
<div class='container'>
<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Form Tambah Tipe Member</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form id='xyz'>
				<div class="modal-body">
					<table border='0' width='100%'>
						<tr>
							<td>Nama Tipe Member</td>
							<td>
								<input type='text' name='nama_tipe_member' class='form-control'
								value='<?=isset($row->nama_tipe_member) ? $row->nama_tipe_member : ''?>'
								<?=isset($row->nama_tipe_member) ? 'readonly' : ''?>>
							</td>
						</tr>
						<tr>
							<td>Limit Pinjam(hari)</td>
							<td>
								<input type='number' name='limit_pinjam' class='form-control' min='3' 
								value='<?=isset($row->limit_pinjam) ? $row->limit_pinjam : '3'?>'>
							</td>
						</tr>
						<tr>
							<td>Lama Pinjam(hari)</td>
							<td>
								<input type='number' name='lama_pinjam' class='form-control'  min='7' 
								value='<?=isset($row->lama_pinjam) ? $row->lama_pinjam : '7'?>'>
							</td>
						</tr>
						<tr>
							<td>Masa Tenggang(hari)</td>
							<td>
								<input type='number' name='masa_tenggang' class='form-control'  min='0' 
								value='<?=isset($row->masa_tenggang) ? $row->masa_tenggang : '0'?>'>
							</td>
						</tr>
						<tr>
							<td>Denda Per Hari</td>
							<td>
								<input type='number' name='denda_perhari' class='form-control'  min='0' 
								value='<?=isset($row->denda_perhari) ? $row->denda_perhari : '0'?>'>
							</td>
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<input type='hidden' name='ref' value='<?=isset($row->tipe_member_id) ? md5($row->tipe_member_id) : '0'?>'>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-info" id='simpan'>Simpan</button>
				</div>
			</form>
		</div>
</div>
</div>
