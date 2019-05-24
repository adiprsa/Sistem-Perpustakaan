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
							<h4>Detail Bibliografi</h4>
						</div>
						<div class="card-body">
                            <div class="table-responsive">
                            	<table class="table">
                            		<tr>
                            			<td rowspan="5" colspan="3" >
                            				<?php if(isset($buku)){ ?><img src="data:image/png;base64,<?php echo base64_encode($buku['gambar']);?>" style="max-width: 300px">
                            				<?php } ?>
                            			</td>
                            			<td>Judul Buku</td>
                            			<td width="10px">:</td>
                            			<td><?=isset($buku)?$buku['judul']:'';?></td>
                            		</tr>
                            		<tr>
                            			<td>Edisi</td>
                            			<td>:</td>
                            			<td><?=isset($buku)?$buku['edisi']:'';?></td>
                            		</tr>
                                    <tr>
                                        <td>Tahun</td>
                                        <td>:</td>
                                        <td><?=isset($buku)?$buku['tahun_terbit']:'';?></td>
                                    </tr>
                                    <tr>
                                        <td>ISBN-ISSN</td>
                                        <td>:</td>
                                        <td><?=isset($buku)?$buku['isbn_issn']:'';?></td>
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
                            			<td>Kategori</td>
                            			<td>:</td>
                            			<td><?=isset($buku)?$buku['nama_kategori']:'';?></td>
                            		</tr>
                                    <tr>
                                        <td>Notes</td>
                                        <td>:</td>
                                        <td><?=isset($buku)?$buku['notes']:'';?></td>

                                        <td>Label</td>
                                        <td>:</td>
                                        <td><?=isset($buku)?$buku['labels']:'';?></td>
                                    </tr>
                            	</table>
                            </div>
                            <hr>
                            <a href='<?=site_url('buku/form/edit?id_biblio='.$buku['biblio_id']);?>' class='btn btn-warning'> Edit </a>
                            <!-- <a href='javascript:void(0)' onclick="hapus('<?=$buku['biblio_id']?>','<?=$buku['judul']?>')" class='btn btn-danger'> Hapus </a> -->
                            <a href='javascript:void(0)' class='btn btn-success nomorPanggil' data-callnumber='<?=$buku['call_number']?>' >Cetak Nomor Panggil</a>
                        </div>                        
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Detail Bibliografi</h4>
                        </div>
                        <div class="card-body">
                            <div class=" table-responsive">
                                <table class="table">
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Item</th>
                                        <th>Tanggal Terima</th>
                                        <th>Supplier</th>
                                        <th>Lokasi</th>
                                        <th>Rak</th>
                                        <th>Asal</th>
                                        <th>Harga</th>
                                    </tr>
                                    <?php if ($item) { $no=1;
                                        foreach ($item as $key => $value) {
                                            echo "<tr><td>".$no."</td>
                                                        <td>".$value['kode_item']."</td>
                                                        <td>".date('d-m-Y',strtotime($value['tgl_terima']))."</td>
                                                        <td>".$value['nama_supplier']."</td>
                                                        <td>".$value['nama_lokasi']."</td>
                                                        <td>".$value['nama_rak']."</td>
                                                        <td>".$value['asal']."</td>
                                                        <td>".$value['harga']."</td>
                                                        <td>
                                                            <a href='javascript:void(0)' class='btn btn-success cetakKode' data-kode_item='".$value['kode_item']."' >Cetak barcode</a>
                                                        </td>
                                                    </tr>";
                                        }
                                    } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>
<script type="text/javascript">
$('.cetakKode').click(function() {
    var kode_item = $(this).data('kode_item');
    window.open("<?= site_url('buku/cetak');?>?jenis=kode_item&kode_item="+kode_item,"jendela cetak", "width=500, height=400");
})
$('.nomorPanggil').click(function() {
    var callnumber = $(this).data('callnumber');
    window.open("<?= site_url('buku/cetak');?>?jenis=callnumber&callnumber="+callnumber,"jendela cetak", "width=500, height=400");
})
</script>