<!-- ============================================================== -->
<!-- wrapper  -->
<!-- Datatable -->
<script src="<?= base_url('assets/datatable') ?>/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="<?= base_url('assets/datatable') ?>/dataTables.bootstrap.min.css">
<!-- ./End Datatable -->

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
									<li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">Master Data</a></li>
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
                                <button type='button' class='btn btn-success' id='tambah'>Tambah</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tipe-member" class="table table-striped table-bordered second" style="width:100%">
                                        <thead>
                                            <tr>
												<th>No</th>
                                                <th>Nama Tipe Member</th>
												<th>Limit Pinjam</th>
												<th>Lama Pinjam</th>
												<th>Denda</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php 
												$no = 1;
												foreach ($data->result() as $row)
												{
											?>
												<tr>
													<td><?php echo $no;?>.</td>
													<td><?php echo $row->nama_tipe_member;?></td>
													<td><?php echo $row->limit_pinjam;?> buku</td>
													<td><?php echo $row->lama_pinjam;?> hari</td>
													<td><?php echo $this->convertion->rupiah($row->denda_perhari);?></td>
													<td>
														<button type="button" class="btn btn-info ganti"  
														id="<?php echo sha1($row->tipe_member_id);?>">Ubah</button>
														<button type="button" class="btn btn-warning hapus" 
														id="<?php echo sha1($row->tipe_member_id);?>">Hapus</button>
													</td>
												</tr>
											<?php
												$no++;
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
				<div id="modal_form" class="modal" data-width="600">
					<div id="tampil_form"></div>
				</div>
		</div>
	</div>
