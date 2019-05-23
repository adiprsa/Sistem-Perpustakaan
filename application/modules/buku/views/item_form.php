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
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="card">
						<div class="card-header">
							<h4>Bibliografi</h4>
						</div>
						<div class="card-body">
                            <div class="table-responsive">
                            	<table class="table">
                            		<tr>
                            			<td rowspan="5" width="350px">
                            				<?php if(isset($buku)){ ?><img src="data:image/png;base64,<?php echo base64_encode($buku['gambar']);?>" style="max-width: 300px">
                            				<?php } ?>
                            			</td>
                            			<td>Judul Buku</td>
                            			<td width="10px">:</td>
                            			<td><?=isset($buku)?$buku['judul']:'';?></td>
                            		</tr>
                            		<tr>
                            			<td>Penerbit</td>
                            			<td>:</td>
                            			<td><?=isset($buku)?$buku['nama_penerbit']:'';?></td>
                            		</tr>
                            		<tr>
                            			<td>Pengarang</td>
                            			<td>:</td>
                            			<td><?php if(isset($pengarang)){
                            				foreach ($pengarang as $key => $value) {
                            					//print_r($value);
                            					echo $value['nama_pengarang']."</br>";
                            				}
                            			} ?>                           				
                            			</td>
                            		</tr>
                            		<tr>
                            			<td>Tahun Terbit</td>
                            			<td>:</td>
                            			<td><?=isset($buku)?$buku['tahun_terbit']:'';?></td>
                            		</tr>
                            	</table>
                            </div>
                        </div>
                    </div>
                </div>
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
							    			<td>Kode Item</td>
							    			<td>
							    				<input type="hidden" name="biblio_id" value="<?=isset($buku)?$buku['biblio_id']:'';?>">
							    				<input type="text" name="kode_item" class="form-control" value="<?=isset($item)?$item['kode_item']:'';?>">
							    			</td>
							    		</tr>
							    		<tr>
							    			<td>Tanggal Terima</td>
							    			<td><input type="text" name="tgl_terima" class="form-control" value="<?=isset($item)?$item['tgl_terima']:'';?>"></td>
							    		</tr>
							    		<tr>
							    			<td>Suplier</td>
							    			<td>
							    				<select name="siplier_id" class="form-control">
							    					<option value=""></option>
							    					<?php foreach ($suplier as $key => $value) {
										                $selected = "";
										                if (isset($item)&&$item['suplier_id']==$value['suplier_id']) {
										                  $selected='selected';
										                }
										                echo "<option ".$selected." value='".$value['suplier_id']."'>".$value['nama_suplier']."</option>";
										              } ?>
							    				</select>
							    			</td>
							    		</tr>
							    		<tr>
							    			<td>No Order</td>
							    			<td><input type="text" name="no_order" class="form-control" value="<?=isset($item)?$item['no_order']:'';?>"></td>
							    		</tr>
							    		<tr>
							    			<td>Lokasi</td>
							    			<td>
							    				<select name="lokasi_id" class="form-control">
							    					<option value=""></option>
							    					<?php foreach ($lokasi as $key => $value) {
										                $selected = "";
										                if (isset($item)&&$item['lokasi_id']==$value['lokasi_id']) {
										                  $selected='selected';
										                }
										                echo "<option ".$selected." value='".$value['lokasi_id']."'>".$value['nama_lokasi']."</option>";
										              } ?>
							    				</select>
							    			</td>
							    		</tr>
							    		<tr>
							    			<td>Nama Rak</td>
							    			<td><input type="text" name="nama_rak" class="form-control" value="<?=isset($item)?$item['nama_rak']:'';?>"></td>
							    		</tr>								    		
							    		<tr>
							    			<td>Tanggal Order</td>
							    			<td><input type="text" name="tgl_order" class="form-control" value="<?=isset($item)?$item['tgl_order']:'';?>"></td>
							    		</tr>
							    		<tr>
							    			<td>Asal</td>
							    			<td><input type="text" name="asal" class="form-control" value="<?=isset($item)?$item['asal']:'';?>"></td>
							    		</tr>
							    		<tr>
							    			<td>Invoice</td>
							    			<td><input type="text" name="invoice" class="form-control" value="<?=isset($item)?$item['invoice']:'';?>"></td>
							    		</tr>
							    		<tr>
							    			<td>Harga</td>
							    			<td><input type="text" name="harga" class="form-control" value="<?=isset($item)?$item['harga']:'';?>"></td>
							    		</tr>								    		
							    	</table>
							    	<input type="submit" value="SIMPAN" class="btn btn-primary" >
							    </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>