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
								    			<td>Nomor Panggil</td>
								    			<td><input type="text" name="call_number" class="form-control" value="<?=isset($buku)?$buku['call_number']:'';?>"></td>
								    		</tr>
								    		<tr>
								    			<td>Tipe Kolasi</td>
								    			<td>
								    				<select name="tipe_kolasi" class="form-control">
								    					<option value=""></option>
								    					<?php foreach ($tipe_kolasi as $key => $value) {
											                $selected = "";
											                if (isset($buku)&&$buku['tipe_kolasi']==$value['tipe_kolasi_id']) {
											                  $selected='selected';
											                }
											                echo "<option ".$selected." value='".$value['tipe_kolasi_id']."'>".$value['nama_tipe_kolasi']."</option>";
											              } ?>
								    				</select>
								    			</td>
								    		</tr>					    		
								    		<tr>
								    			<td>Kode Item</td>
								    			<td><input type="text" name="kode_item" class="form-control" value="<?=isset($buku)?$buku['kode_item']:'';?>"></td>
								    		</tr>
								    		<tr>
								    			<td>Kode Inventaris</td>
								    			<td><input type="text" name="kode_inventaris" class="form-control" value="<?=isset($buku)?$buku['kode_inventaris']:'';?>"></td>
								    		</tr>
								    		<tr>
								    			<td>Tanggal Terima</td>
								    			<td><input type="text" name="tgl_terima" class="form-control" value="<?=isset($buku)?$buku['tgl_terima']:'';?>"></td>
								    		</tr>
								    		<tr>
								    			<td>Suplier</td>
								    			<td>
								    				<select name="siplier_id" class="form-control">
								    					<option value=""></option>
								    					<?php foreach ($suplier as $key => $value) {
											                $selected = "";
											                if (isset($buku)&&$buku['suplier_id']==$value['suplier_id']) {
											                  $selected='selected';
											                }
											                echo "<option ".$selected." value='".$value['suplier_id']."'>".$value['nama_suplier']."</option>";
											              } ?>
								    				</select>
								    			</td>
								    		</tr>
								    		<tr>
								    			<td>No Order</td>
								    			<td><input type="text" name="no_order" class="form-control" value="<?=isset($buku)?$buku['no_order']:'';?>"></td>
								    		</tr>
								    		<tr>
								    			<td>Lokasi</td>
								    			<td>
								    				<select name="lokasi_id" class="form-control">
								    					<option value=""></option>
								    					<?php foreach ($lokasi as $key => $value) {
											                $selected = "";
											                if (isset($buku)&&$buku['lokasi_id']==$value['lokasi_id']) {
											                  $selected='selected';
											                }
											                echo "<option ".$selected." value='".$value['lokasi_id']."'>".$value['nama_lokasi']."</option>";
											              } ?>
								    				</select>
								    			</td>
								    		</tr>
								    		<tr>
								    			<td>Nama Rak</td>
								    			<td><input type="text" name="nama_rak" class="form-control" value="<?=isset($buku)?$buku['nama_rak']:'';?>"></td>
								    		</tr>								    		
								    		<tr>
								    			<td>Tanggal Order</td>
								    			<td><input type="text" name="tanggal_order" class="form-control" value="<?=isset($buku)?$buku['tanggal_order']:'';?>"></td>
								    		</tr>
								    		<tr>
								    			<td>Asal</td>
								    			<td><input type="text" name="asal" class="form-control" value="<?=isset($buku)?$buku['asal']:'';?>"></td>
								    		</tr>
								    		<tr>
								    			<td>Invoice</td>
								    			<td><input type="text" name="invoice" class="form-control" value="<?=isset($buku)?$buku['invoice']:'';?>"></td>
								    		</tr>
								    		<tr>
								    			<td>Harga</td>
								    			<td><input type="text" name="harga" class="form-control" value="<?=isset($buku)?$buku['harga']:'';?>"></td>
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