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
                        <h2 class="pageheader-title">Statistik Koleksi Buku</h2>
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Statistik</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Statistik Koleksi Buku</li>
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
                                <form method="POST" action="tampil_statistik_buku">
                                    <div class="form-row">
                                        <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 col-12 mb-2">
                                            <label>Filter</label>
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

                            <script>
                                $(document).ready(function () {
                                    showGraph();
                                });


                                const unique = (value, index, self) => {
                                    return self.indexOf(value) === index;
                                }

                                function showGraph() {
                                    var data = <?php echo json_encode($buku); ?>;
                                    var list_month = [];
                                    var list_jenis = [];
                                    var data_sets = []
                                    var data_pinjam = {}
                                    var color_list = ['#1133CC', '#33CC11', '#CC1133', '#FF4466', '#66FF44', '#4466FF'];

                                    for (var i in data) {
                                        list_month.push(data[i].month);
                                        list_jenis.push(data[i].klasifikasi);
                                    }
                                    var month_list = list_month.filter(unique);
                                    var jenis_list = list_jenis.filter(unique);

                                    for (var i in jenis_list) {
                                        data_pinjam[i] = [];
                                        for (var j in month_list) {
                                            var data_pj = "0";
                                            for (var k in data) {
                                                if (data[k].month == month_list[j] && data[k].klasifikasi == jenis_list[i]) {
                                                    data_pj = data[k].tot_buku;
                                                }
                                            }
                                            data_pinjam[i].push(data_pj);
                                        }
                                        data_sets.push({
                                            label: jenis_list[i],
                                            backgroundColor: color_list[i],
                                            borderColor: '#000000',
                                            hoverBackgroundColor: color_list[(color_list.length - 1) - i],
                                            hoverBorderColor: '#ffffff',
                                            data: data_pinjam[i]
                                        });
                                    }

                                    var chartdata = {
                                        labels: month_list,
                                        datasets: data_sets
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
