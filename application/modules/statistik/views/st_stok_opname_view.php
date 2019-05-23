<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/datatables/css/dataTables.bootstrap4.css')?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/datatables/css/dataTables.bootstrap4.min.css')?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/datatables/css/buttons.bootstrap4.css')?>">
    
<script type="text/javascript" src="<?php echo base_url('/assets/libs/js/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('/assets/libs/js/Chart.min.js') ?>"></script>

<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Statistik Stok Opname</h2>
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Statistik</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Statistik Stok Opname</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Statistik</p>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <form method="POST" action="tampil_statistik_stok_opname">
                                    <div class="form-row">
                                        <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 col-12 mb-2">
                                            <label>Tanggal</label>
                                        </div>
                                        <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 col-12 mb-2">
                                            <input type="date" class="form-control" id="date" name="date" required>
                                        </div>
                                        <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 col-12 mb-2 ">
                                            <button class="btn btn-primary btn-sm"  id="submit">Cari</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div id="chart-container">
                                <canvas id="graphCanvas"></canvas>
                            </div>

                            <?php
                                $month = [];
                                foreach ($stok_opname as $data) {
                                    $date[] = $data->tgl_mulai;
                                    $hilang[] = $data->total_item_hilang;
                                    $ada[] = $data->total_item_ada;
                                    $pinjam[] = $data->total_item_dipinjam;
                                }

                            ?>

                            <script>
                                $(document).ready(function () {
                                    showGraph();
                                });

                                function showGraph() {
                                    var chartdata = {
                                        labels: <?php echo json_encode($date); ?>,
                                        datasets: [
                                            {
                                                label: 'Item Ada',
                                                backgroundColor: '#1133CC',
                                                borderColor: '#000000',
                                                hoverBackgroundColor: '#4466FF',
                                                hoverBorderColor: '#666666',
                                                data: <?php echo json_encode($ada); ?>
                                            },
                                            {
                                                label: 'Item Dipinjam',
                                                backgroundColor: '#33CC11',
                                                borderColor: '#000000',
                                                hoverBackgroundColor: '#66FF44',
                                                hoverBorderColor: '#666666',
                                                data: <?php echo json_encode($pinjam); ?>
                                            },
                                            {
                                                label: 'Item Hilang',
                                                backgroundColor: '#CC1133',
                                                borderColor: '#000000',
                                                hoverBackgroundColor: '#FF4466',
                                                hoverBorderColor: '#666666',
                                                data: <?php echo json_encode($hilang); ?>
                                            }
                                        ]
                                    };

                                    var graphTarget = $("#graphCanvas");

                                    var barGraph = new Chart(graphTarget, {
                                        type: 'bar',
                                        data: chartdata,
                                        options: {
                                            responsive: true,
                                            scales: {
                                                yAxes: [{
                                                    display: true,
                                                    ticks: {
                                                        beginAtZero: true,
                                                    }
                                                }]
                                            }
                                        }
                                    });
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
