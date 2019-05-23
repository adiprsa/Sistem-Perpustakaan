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
						<h2 class="pageheader-title">Sistem Perpustakaan Udinus </h2>
						<!--<p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
						-->
						<div class="page-breadcrumb">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
									
								</ol>
							</nav>
						</div>
					</div>
				</div>
			</div>
			<!-- ============================================================== -->
			<!-- end pageheader  -->
			<!-- ============================================================== -->
			<div class="ecommerce-widget">
				<div class="row">
					<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
						<div class="card">
							<div class="card-body">
								<h5 class="text-muted">Peminjaman Bulan Ini</h5>
								<div class="metric-value d-inline-block">
									<h1 class="mb-1"><?=$pinjaman_bulan?></h1>
								</div>
							</div>
							<div id="sparkline-revenue"></div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
						<div class="card">
							<div class="card-body">
								<h5 class="text-muted">Jumlah Member</h5>
								<div class="metric-value d-inline-block">
									<h1 class="mb-1"><?=$jumlah_member?></h1>
								</div>
								<div class="metric-label d-inline-block float-right text-success font-weight-bold">
									<span><i class="fa fa-fw fa-arrow-up"></i></span><span><?=$jumlah_member_bulan?>
									</span>
								</div>
							</div>
							<div id="sparkline-revenue2"></div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
						<div class="card">
							<div class="card-body">
								<h5 class="text-muted">Denda Bulan Ini</h5>
								<div class="metric-value d-inline-block">
									<h1 class="mb-1"><?=(isset($jumlah_denda_bulan) AND $jumlah_denda_bulan > 0) ? $jumlah_denda_bulan : 0?></h1>
								</div>
							</div>
							<div id="sparkline-revenue3"></div>
						</div>
					</div>
					
				</div>
				<div class="row">
					<!-- ============================================================== -->
				
					<!-- ============================================================== -->

									<!-- recent orders  -->
					<!-- ============================================================== -->
					<script src="<?=base_url()?>assets/chart/Chart.min.js"></script>
					<script src="<?=base_url()?>assets/chart/utils.js"></script>
					<style>
					canvas{
						-moz-user-select: none;
						-webkit-user-select: none;
						-ms-user-select: none;
					}
					</style>
					<div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
						<div class="card">
							<h5 class="card-header">Statistik Peminjaman</h5>
							<div class="card-body p-0">
								<div style="width:100%;">
									<canvas id="canvas"></canvas>
								</div>
							</div>
						</div>
					</div>
					<!-- ============================================================== -->
					<!-- end recent orders  -->
					<script>
					var config = {
			type: 'line',
			data: {
				labels: <?=json_encode($tanggal_chart)?>,
				datasets: [{
					label: 'Peminjaman',
					backgroundColor: window.chartColors.blue,
					borderColor: window.chartColors.black,
					data: <?=json_encode($grafik_pinjam)?>,
					fill: false,
				}, {
					label: 'Jadwal Pengembalian',
					fill: false,
					backgroundColor: window.chartColors.yellow,
					borderColor: window.chartColors.black,
					data: <?=json_encode($grafik_harus_balik)?>,
				}, {
					label: 'Realisasi Pengembalian',
					fill: false,
					backgroundColor: window.chartColors.green,
					borderColor: window.chartColors.black,
					data: <?=json_encode($grafik_jadi_balik)?>,
				}]
			},
			options: {
				responsive: true,
				title: {
					display: true,
					text: 'Statistik Peminjaman dan Pengembalian'
				},
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					xAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Month'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Value'
						}
					}]
				}
			}
		};
		window.onload = function() {
			var ctx = document.getElementById('canvas').getContext('2d');
			window.myLine = new Chart(ctx, config);
		};

		
					</script>

					<!-- ============================================================== -->
					<!-- ============================================================== -->
					<!-- customer acquistion  -->
					<!-- ============================================================== -->
					<!-- ============================================================== -->
					<!-- end customer acquistion  -->
					<!-- ============================================================== -->
				</div>
				
			</div>
		</div>
	</div>