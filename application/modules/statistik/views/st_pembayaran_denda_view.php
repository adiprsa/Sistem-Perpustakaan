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
                        <h2 class="pageheader-title">Statistik Pembayaran Denda</h2>
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Statistik</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Statistik Pembayaran Denda</li>
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
                                <form method="POST" action="tampil_statistik_pembayaran_denda">
                                    <div class="form-row">
                                        <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 col-12 mb-2">
                                            <label>Tanggal</label>
                                        </div>
                                        <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 col-12 mb-2">
                                            <select name="month" class="form-control"">
                                                <option name="" disabled selected>Month</option>
                                                <option name="January">January</option>
                                                <option name="February">February</option>
                                                <option name="March">March</option>
                                                <option name="April">April</option>
                                                <option name="May">May</option>
                                                <option name="June">June</option>
                                                <option name="July">July</option>
                                                <option name="August">August</option>
                                                <option name="September">September</option>
                                                <option name="October">October</option>
                                                <option name="November">November</option>
                                                <option name="December">December</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 col-12 mb-2">
                                            <select name="year" class="form-control">
                                                <option name="" disabled selected>Year</option>
                                                <option name="2017">2017</option>
                                                <option name="2018">2018</option>
                                                <option name="2019">2019</option>
                                                <option name="2020">2020</option>
                                                <option name="2021">2021</option>
                                            </select>
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
                                foreach ($bayar_denda as $data) {
                                    $month[] = $data->month;
                                    $sum[] = $data->tot_denda;
                                }
                                if ($month == null) {
                                    $month = ['January'];
                                    $sum = ['0'];
                                }

                            ?>

                            <script>
                                $(document).ready(function () {
                                    showGraph();
                                });

                                function showGraph() {
                                    var month = <?php echo json_encode($month); ?>;
                                    var sum = <?php echo json_encode($sum); ?>;

                                    var chartdata = {
                                        labels: month,
                                        datasets: [
                                            {
                                                label: 'Pembayaran Denda',
                                                backgroundColor: '#CC1133',
                                                borderColor: '#000000',
                                                hoverBackgroundColor: '#FF4466',
                                                hoverBorderColor: '#666666',
                                                data: sum
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
