<!-- ============================================================== -->
<!-- wrapper  -->
<script src="<?= base_url('assets/datatable') ?>/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="<?= base_url('assets/datatable') ?>/dataTables.bootstrap.min.css">

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
									<li class="breadcrumb-item active" aria-current="page"><?=$title?></li>
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
                                <button type='button' class='btn btn-info tambah'>Tambah</button>
                                <button type='button' class='btn btn-success import'>Import Data Libur</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped table-bordered second" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Tanggal Libur</th>
                                                <th>Keterangan Libur</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
											foreach($hari_libur->result() as $aa => $bb){
												?>
												<tr>
													<td><?=$this->convertion->mysql2normal($bb->tgl_libur)?></td>
													<td><?=$bb->hari_libur?></td>
													<td>
													<button type='button' class='btn btn-warning ganti' id='<?=sha1($bb->libur_id)?>'>Ubah</button>
													<button type='button' class='btn btn-danger hapus' id='<?=sha1($bb->libur_id)?>'>Hapus</button>
													</td>
												</tr>
												<?php
											}
											?>
                                        </tbody>
                                    </table>
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
	<script>
	$(document).ready(function() {
	   table = $('#example').DataTable();
		
		
	});
	</script>
<div id="modal_form" class="modal" data-width="600">
	<div id="tampil_form"></div>
</div>

<script>				
	$(document).on('click','.ganti',function(){
					$('#tampil_form').load("<?=site_url()?>pengaturan/libur/modal_form_libur/"+ $(this).attr('id'),function(){
					$('#modal_form').modal('show');
					});
				});
	$(document).on('click','.tambah',function(){
					$('#tampil_form').load("<?=site_url()?>pengaturan/libur/modal_form_libur/",function(){
					$('#modal_form').modal('show');
					});
				});
	$(document).on('click','.import',function(){
		$('#tampil_form').load("<?=site_url()?>pengaturan/libur/modal_import_libur/",function(){
		$('#modal_form').modal('show');
		});
	});

	$(document).on('click','.hapus',function(){
		var cnf = confirm("Apakah anda yakin akan menghapus data ini?");
		if (cnf == true) {
			//alert ($(this).attr('id'));
			location.href = '<?=site_url()?>pengaturan/libur/hapus_libur/' + $(this).attr('id');
		}				
	});
	
	
</script>