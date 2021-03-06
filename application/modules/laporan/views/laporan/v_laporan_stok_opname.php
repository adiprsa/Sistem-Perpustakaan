<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/datatables/css/dataTables.bootstrap4.css')?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/datatables/css/dataTables.bootstrap4.min.css')?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/datatables/css/buttons.bootstrap4.css')?>">
    
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-datatable/jquery.dataTables.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-datatable/extensions/export/jszip.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-datatable/extensions/export/pdfmake.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-datatable/extensions/export/vfs_fonts.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-datatable/extensions/export/buttons.print.min.js') ?>"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('table').DataTable({
            searching : true,
            ordering : true,
            paging : false,
            dom : 'Bfrtip',
            responsive : true,
            buttons : ['excel']
        });
    });
</script>
<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Laporan Stok Opname </h2>
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Laporan</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Laporan Stok Opname</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Data Laporan Stok Opname</p>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <form method="POST" action="tampil_laporan_stok_opname">
                                    <div class="form-row">
                                        <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 col-12 mb-2">
                                            <select class="form-control" id="filter" name="filter">
                                                <option value=""></option>
                                                <option value="tgl_mulai">Tanggal Mulai</option>
                                                <option value="tgl_selesai">Tanggal Selesai</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 col-12 mb-2">
                                            <input type="date" class="form-control" id="tgl1" name="tgl1" placeholder="City" required>
                                        </div>
                                        <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 col-12 mb-2">
                                            <input type="date" class="form-control" id="tgl2" name="tgl2" placeholder="State" required>
                                        </div>
                                        <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 col-12 mb-2 ">
                                            <button class="btn btn-primary btn-sm"  id="submit">Cari</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table id="example" class="js-exportable table table-stripped responsive" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Kode Buku</th>
                                            <th>Judul</th>
                                            <th>Edisi</th>
                                            <th>ISBN-ISSN</th>
                                            <th>Pengarang</th>
                                            <th>Penerbit</th>
                                            <th>Tahun Terbit</th>
                                            <th>Lokasi Terbit</th>
                                            <th>Total Stok</th>
                                            <th>Total Stok Ada</th>
                                            <th>Total Stok Hilang</th>
                                            <th>Total Stok Dipinjam</th>
                                            <th>Pembuat</th>
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Akhir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1 ?>
                                        <?php foreach ($stok_opname as $data): ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                               <td><?php echo $data->kode_item; ?></td>
                                               <td><?php echo $data->judul; ?></td>
                                               <td><?php echo $data->edisi; ?></td>
                                               <td><?php echo $data->isbn_issn; ?></td>
                                               <td><?php echo $data->nama_pengarang; ?></td>
                                               <td><?php echo $data->nama_penerbit; ?></td>
                                               <td><?php echo $data->tahun_terbit; ?></td>
                                               <td><?php echo $data->nama_tempat; ?></td>
                                               <td><?php echo $data->total_item; ?></td>
                                               <td><?php echo $data->total_item_ada; ?></td>
                                               <td><?php echo $data->total_item_hilang; ?></td>
                                               <td><?php echo $data->total_item_dipinjam; ?></td>
                                               <td><?php echo $data->nama_pembuat; ?></td>
                                               <td><?php echo $data->tgl_mulai; ?></td>
                                               <td><?php echo $data->tgl_selesai; ?></td>
                                            </tr>
                                        <?php endforeach; ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
