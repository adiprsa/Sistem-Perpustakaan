<!-- ============================================================== -->
<!-- wrapper  -->
<!-- ============================================================== -->
<div class="dashboard-wrapper">
	<div class="dashboard-ecommerce">
		<div class="container-fluid dashboard-content ">
			<!-- ============================================================== -->
			<!-- pageheader  -->
			<!-- ============================================================== -->
			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="page-header">
						<h2 class="pageheader-title"><?=$title?> </h2>
						<div class="page-breadcrumb">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">Dashboard</a></li>
									<li class="breadcrumb-item"><a href="<?=base_url($title)?>" class="breadcrumb-link"><?=$title?></a></li>
									<li class="breadcrumb-item active" aria-current="page"><?=$action.' '.$title?></li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
			</div>
			<!-- ============================================================== -->
			<!-- end pageheader  -->
			<!-- ============================================================== -->
			<div class="row">
                    <!-- ============================================================== -->
                    <!-- data table  -->
                    <!-- ============================================================== -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4><?=strtoupper($action." ".$title);?></h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
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
								    			<td>
								    				<select name="penerbit_id" class="form-control">
								    					<option value=""></option>
								    					<?php foreach ($penerbit as $key => $value) {
											                $selected = "";
											                if (isset($buku)&&$buku['penerbit_id']==$value['penerbit_id']) {
											                  $selected='selected';
											                }
											                echo "<option ".$selected." value='".$value['penerbit_id']."'>".$value['nama_penerbit']."</option>";
											              } ?>
								    				</select>
								    			</td>
								    		</tr>
								    		<tr>
								    			<td>Tahun Terbit</td>
								    			<td><input type="text" name="tahun_terbit" class="form-control" value="<?=isset($buku)?$buku['tahun_terbit']:'';?>"></td>
								    		</tr>
								    		<tr>
								    			<td>Kolasi</td>
								    			<td><input type="text" name="kolasi" class="form-control" value="<?=isset($buku)?$buku['kolasi']:'';?>"></td>
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
								    			<td>
								    				<select name="bahasa_id" class="form-control">
								    					<option value=""></option>
								    					<?php foreach ($bahasa as $key => $value) {
											                $selected = "";
											                if (isset($buku)&&$buku['bahasa_id']==$value['bahasa_id']) {
											                  $selected='selected';
											                }
											                echo "<option ".$selected." value='".$value['bahasa_id']."'>".$value['nama_bahasa']."</option>";
											              } ?>
								    				</select>
								    			</td>
								    		</tr>
								    		<tr>
								    			<td>Asal</td>
								    			<td><input type="text" name="asal" class="form-control" value="<?=isset($buku)?$buku['asal']:'';?>"></td>
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
								    			<td><input type="text" name="labels" class="form-control" value="<?=isset($buku)?$buku['labels']:'';?>"></td>
								    		</tr>
								    		<tr>
								    			<td>Frekuensi</td>
								    			<td>
								    				<select name="frekuensi_id" class="form-control">
								    					<option value=""></option>
								    					<?php foreach ($frekuensi as $key => $value) {
											                $selected = "";
											                if (isset($buku)&&$buku['frekuensi_id']==$value['frekuensi_id']) {
											                  $selected='selected';
											                }
											                echo "<option ".$selected." value='".$value['frekuensi_id']."'>".$value['frekuensi']."</option>";
											              } ?>
								    				</select>
								    			</td>
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
								    			<td>Tipe Media</td>
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
								    			<td>Klasifikasi</td>
								    			<td><input type="text" name="klasifikasi" class="form-control" value="<?=isset($buku)?$buku['klasifikasi']:'';?>"></td>
								    		</tr>
								    	</table>
								    	<input type="submit" value="SIMPAN" class="btn btn-primary" >
								    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end data table  -->
                    <!-- ============================================================== -->
                </div>
		</div>
	</div>