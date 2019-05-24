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
                                <a href="javascript:void(0)" class='btn btn-success' onclick="tambah()">Tambah</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="data" class="table table-striped table-bordered second" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kategori</th>
                                                <th>Kode</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php if($kategori){ $no=1; foreach ($kategori as $key => $value) {
                                        		echo "<tr><td>".$no."</td><td>".$value['nama_kategori']."</td>
                                        				<td>".$value['kode_kategori']."</td>
                                        				<td>
                                        					<a href='javascript:void(0)' class='btn btn-warning' onclick='edit(\"".$value['kategori_id']."\")'> Edit </a>
                                        					<a href='javascript:void(0)' class='btn btn-danger' onclick='hapus(\"".$value['kategori_id']."\",\"".$value['nama_kategori']."\")'> Hapus </a>
                                        				</td></tr>";
                                        		$no++;
                                        	} }else{
                                        		echo "Tidak ada data";
                                        	} ?>
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
<div id="popup"></div>
<script type="text/javascript">
	function hapus(idKategori,nmKategori) {
		$.get('<?=site_url('buku/ajax/popup/hapus')?>',
			{id:idKategori,nama:nmKategori,tabel:'kategori'},
			function(data) {
				$('#popup').html(data)
				$('.modal').modal('show');
			})
	}
	function tambah() {
		$.get('<?=site_url('buku/ajax/popup/tambah')?>',
			{tabel:'kategori'},
			function(data) {
				$('#popup').html(data)
				$('.modal').modal('show');
			})
	}
	function edit(idKategori) {
		$.get('<?=site_url('buku/ajax/popup/edit')?>',
			{id:idKategori,tabel:'kategori'},
			function(data) {
				$('#popup').html(data)
				$('.modal').modal('show');
			})
	}
	function yakinHapus(id) {
		$.get('<?=site_url('buku/ajax/hapus/kategori')?>',
			{id:id},
			function(data) {
				if (data.status){
					location.reload();
				}
			})
	}
</script>