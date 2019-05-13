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
                                <a href="<?=site_url('buku/form/tambah')?>" class='btn btn-success'>Tambah</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="data" class="table table-striped table-bordered second" style="width:100%">
                                        <thead>
                                            <tr>
<<<<<<< HEAD:application/modules/buku/views/buku_list.php
                                                <th>No</th>
                                                <th>Judul</th>
                                                <th>ISBN ISSN </th>
												<th>Penerbit</th>
												<th>Tahun Terbit</th>
=======
                                                <th>Nama Pengarang</th>
                                                <th>Tahun Pengarang</th>
                                                <th>Tipe Pengarang</th>
>>>>>>> refs/remotes/origin/master:application/modules/pengaturan/views/main.php
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
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
<div id="modal_form" class="modal" data-width="900">
</div>
<script src="<?= base_url('assets/datatable') ?>/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="<?= base_url('assets/datatable') ?>/dataTables.bootstrap.min.css">
<script>
$(document).ready(function() {
table = $('#data').DataTable({
		"processing": true, //Feature control the processing indicator.
		"serverSide": true, //Feature control DataTables' server-side processing mode.
		"order": [], //Initial no order.
		// Load data for the table's content from an Ajax source
<<<<<<< HEAD:application/modules/buku/views/buku_list.php
		"ajax": {
			"url": "<?=site_url('buku/ajax/buku_datatable')?>",
=======
			"ajax": {
			"url": "<?=site_url('Pengaturan/pengarang_list')?>",
>>>>>>> refs/remotes/origin/master:application/modules/pengaturan/views/main.php
			"type": "POST",
		},
		//Set column definition initialisation properties.
		"columnDefs": [
<<<<<<< HEAD:application/modules/buku/views/buku_list.php
			{
				"targets": [ 0 ], //first column / numbering column
				"orderable": false, //set not orderable
			},
=======
		{
			"targets": [ 0 ], //first column / numbering column
			"orderable": false, //set not orderable
		},
>>>>>>> refs/remotes/origin/master:application/modules/pengaturan/views/main.php
		],
	});
});
</script>