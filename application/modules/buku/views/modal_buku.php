<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
	  <div class="modal-header">
	    <h5 class="modal-title"><?=strtoupper($act);?> BUKU</h5>
	    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	      <span aria-hidden="true">&times;</span>
	    </button>
	  </div>
	  <div class="modal-body">
	    <form method="post">
	    	<table class="table">
	    		<tr>
	    			<td>Judul Buku</td>
	    			<td><input type="text" name="judul" class="form-control" value="<?=isset($buku)?$buku['judul']:'';?>"></td>
	    		</tr>
	    		<tr>
	    			<td>Edisi</td>
	    			<td><input type="text" name="edisi" class="form-control" value="<?=isset($buku)?$buku['edisi']:'';?>"></td>
	    		</tr>
	    		<tr>
	    			<td>ISBN ISSN</td>
	    			<td><input type="text" name="isbn_issn" class="form-control" value="<?=isset($buku)?$buku['isbn_issn']:'';?>"></td>
	    		</tr>
	    		<tr>
	    			<td>Penerbit</td>
	    			<td><input type="text" name="penerbit_id" class="form-control" value="<?=isset($buku)?$buku['penerbit_id']:'';?>"></td>
	    		</tr>
	    		<tr>
	    			<td>Tahun Terbit</td>
	    			<td><input type="text" name="tahun_terbit" class="form-control" value="<?=isset($buku)?$buku['tahun_terbit']:'';?>"></td>
	    		</tr>
	    		<tr>
	    			<td>Kolasi</td>
	    			<td><input type="text" name="kolas" class="form-control" value="<?=isset($buku)?$buku['kolas']:'';?>"></td>
	    		</tr>
	    		<tr>
	    			<td>Judul Seri</td>
	    			<td><input type="text" name="judul_seri" class="form-control" value="<?=isset($buku)?$buku['judul_seri']:'';?>"></td>
	    		</tr>
	    		<tr>
	    			<td>Nomor Panggil</td>
	    			<td><input type="text" name="call_number" class="form-control" value="<?=isset($buku)?$buku['call_number']:'';?>"></td>
	    		</tr>
	    		<tr>
	    			<td>Bahasa</td>
	    			<td><input type="text" name="bahasa_id" class="form-control" value="<?=isset($buku)?$buku['bahasa_id']:'';?>"></td>
	    		</tr>
	    		<tr>
	    			<td>Asal</td>
	    			<td><input type="text" name="Asal" class="form-control" value="<?=isset($buku)?$buku['Asal']:'';?>"></td>
	    		</tr>
	    		<tr>
	    			<td>Tempat Terbit</td>
	    			<td><input type="text" name="tempat_terbit_id" class="form-control" value="<?=isset($buku)?$buku['tempat_terbit_id']:'';?>"></td>
	    		</tr>
	    		<tr>
	    			<td>Catatan</td>
	    			<td><input type="text" name="notes" class="form-control" value="<?=isset($buku)?$buku['notes']:'';?>"></td>
	    		</tr>
	    		<tr>
	    			<td>Gambar</td>
	    			<td><input type="file" name="gambar" class="form-control"></td>
	    		</tr>
	    		<tr>
	    			<td>Labels</td>
	    			<td><input type="text" name="Label" class="form-control" value="<?=isset($buku)?$buku['Label']:'';?>"></td>
	    		</tr>
	    		<tr>
	    			<td>Frekuensi</td>
	    			<td><input type="text" name="frekuensi_id" class="form-control" value="<?=isset($buku)?$buku['frekuensi_id']:'';?>"></td>
	    		</tr>
	    		<tr>
	    			<td>Tipe Konten</td>
	    			<td>
	    				<select name="tipe_konten_id" class="form-control">
	    					<option value=""></option>
	    					<?php foreach ($tipe_konten as $key => $value) {
				                $selected = "";
				                if (isset($buku)&&$buku['tipe_konten_id']==$value['id']) {
				                  $selected='selected';
				                }
				                echo "<option ".$selected." value='".$value['id']."'>".$value['tipe_konten']."</option>";
				              } ?>
	    				</select>
	    			</td>
	    		</tr>
	    		<tr>
	    			<td>tipe media</td>
	    			<td>
	    				<select name="tipe_media_id" class="form-control">
	    					<option value=""></option>
	    					<?php foreach ($tipe_media as $key => $value) {
				                $selected = "";
				                if (isset($buku)&&$buku['tipe_media_id']==$value['id']) {
				                  $selected='selected';
				                }
				                echo "<option ".$selected." value='".$value['id']."'>".$value['tipe_media']."</option>";
				              } ?>
	    				</select>
	    			</td>
	    		</tr>
	    		<tr>
	    			<td>klasifikasi</td>
	    			<td><input type="text" name="judul" class="form-control" value="<?=isset($buku)?$buku['judul']:'';?>"></td>
	    		</tr>
	    	</table>
	    </form>
	  </div>
	  <div class="modal-footer">
	    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	    <button type="button" class="btn btn-primary">Save changes</button>
	  </div>
	</div>
</div>