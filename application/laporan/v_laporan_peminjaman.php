<?php $this->load->view('template/header.php') ?>
<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Laporan Peminjaman </h2>
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Laporan</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Laporan Peminjaman</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Data Laporan Peminjaman</p>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <form method="POST" action="tampil_laporan_peminjaman">
                                    <div class="form-row">
                                        <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 col-12 mb-2">
                                            <select class="form-control" id="filter" name="filter">
                                                <option value=""></option>
                                                <option value="tgl_pinjam">Tanggal Pinjam</option>
                                                <option value="tgl_harus_kembali">Tanggal Harus Kembali</option>
                                                <option value="tgl_kembali">Tanggal Kembali</option>
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
                                            <th>Kategori Buku</th>
                                            <th>Status Buku</th>
                                            <th>Peminjam</th>
                                            <th>Tanggal Peminjaman</th>
                                            <th>Tanggal Harus Kembali</th>
                                            <th>Tanggal Kembali</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1 ?>
                                        <?php foreach ($peminjaman as $data): ?>
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
                                               <td><?php echo $data->klasifikasi; ?></td>
                                               <td><?php echo $data->nama_status; ?></td>
                                               <td><?php echo $data->nama_member; ?></td>
                                               <td><?php echo $data->tgl_pinjam; ?></td>
                                               <td><?php echo $data->tgl_harus_kembali; ?></td>
                                               <td><?php echo $data->tgl_kembali; ?></td>
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
<?php $this->load->view('template/footer.php') ?>