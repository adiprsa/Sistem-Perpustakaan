<?php $this->load->view('template/header.php') ?>
<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Laporan Anggota </h2>
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Laporan</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Laporan Anggota</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Data Laporan Anggota</p>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <form method="POST" action="tampil_laporan_anggota">
                                    <div class="form-row">
                                        <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 col-12 mb-2">
                                            <label>Tanggal Keanggotaan</label>
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
                                            <th>Kode Anggota</th>
                                            <th>Name</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Alamat</th>
                                            <th>Email</th>
                                            <th>Institusi</th>
                                            <th>Tanggal Keanggotaan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1 ?>
                                        <?php foreach ($anggota as $data): ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $data->member_code ?></td>
                                                <td><?php echo $data->nama_member ?></td>
                                                <td><?php echo $data->jenis_kelamin ?></td>
                                                <td><?php echo $data->alamat ?></td>
                                                <td><?php echo $data->email ?></td>
                                                <td><?php echo $data->institusi ?></td>
                                                <td><?php echo $data->tgl_register ?></td>
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
<!-- <script type="text/javascript">
    $('#submit').click(function(){
        var datas = new FormData();
        datas.append('tgl1',$('#tgl1').val());
        datas.append('tgl2',$('#tgl2').val());

        $.ajax({
          type  : 'POST',
          url   : '<?php echo base_url('c_laporan/test') ?>',
          data  : datas,
          datatype  : 'JSON',
          success   : function(data){
            alert(data);
              console.log(data);
              $('#editModal').modal("hide");
              swal({
                title: "Success",
                text: "User berhasil di update",
                type: "success"
            }, function(){
              location.reload();
          });
          }
      })
    }
</script> -->