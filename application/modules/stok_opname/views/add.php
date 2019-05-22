<!-- bootstap datepicker js -->
<script src="<?php echo base_url('assets/vendor/datepicker/moment.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/datepicker/tempusdominus-bootstrap-4.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/datepicker/datepicker.js') ?>"></script>
<script type="text/javascript">
  $(document).ready(function() {
    // $('#responsive-datatable').DataTable({
    //   "pageLength": 25
    // });
    $('#dt_tgl_mulai').datetimepicker({
      format: 'L'
    });

    $('#dt_tgl_selesai').datetimepicker({
      format: 'L'
    });

    $("#btnSave").on('click', (function(e) {
      e.preventDefault();
      var id = $('#id').val();
      var nama_stok_opname = $('#nama_stok_opname').val();
      var tgl_mulai = $('#tgl_mulai').val();
      var tgl_selesai = $('#tgl_selesai').val();
      var pembuat = $('#pembuat').val();
      
      if (id != '' && nama_stok_opname != '' && tgl_mulai != '' && tgl_selesai != '' && pembuat != '') {
        $.ajax({
          url: "<?= base_url('/stok_opname/save') ?>",
          type: "POST",
          data: {
            'id': id,
            'nama_stok_opname': nama_stok_opname,
            'tgl_mulai': tgl_mulai,
            'tgl_selesai': tgl_selesai,
            'pembuat': pembuat,
          },
          beforeSend: function(result) {
            $('#btnSave').prop('disabled', true);
          },
          success: function(resp) {
            var obj = JSON.parse(resp);
            showMessage(obj.type, obj.error_code, obj.messages);
            setTimeout(function() {
              window.location.assign('/stok_opname');
            }, 1500);
          },
          error: function() {
            showMessage('error', '500', 'Terjadi Kegagalan Proses');
          }
        });
      } else {
        showMessage('error', '500', 'Silahkan Cek Input anda!');
        $('#nama_stok_opname').focus();
      }
    }));

  });
</script>
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
            <h2 class="pageheader-title"><?= $title ?> </h2>
            <div class="page-breadcrumb">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="breadcrumb-link">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
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
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="card">
            <h5 class="card-header">Tambah Waktu Stok Opname</h5>
            <div class="card-body">
              <?php
              $submit = "stok_opname/save";
              $attributes = array(
                'role' => 'form', 'id' => 'form_add', 'name' => 'form_add', 'class' => 'form-horizontal', 'onSubmit' => 'document.getElementById(\'btn\').disabled=true;'
              );
              echo form_open($submit, $attributes);
              ?>
              <input id="nama" type="hidden" name="id" data-parsley-type="id">
              <div class="form-group row">
                <label for="nama" class="col-3 col-lg-2 col-form-label text-right">Nama Waktu</label>
                <div class="col-3 col-lg-4">
                  <input id="nama_stok_opname" type="text" name="nama_stok_opname" data-parsley-type="nama" placeholder="Nama Stok Opname" class="form-control" required>
                </div>
              </div>
              <div class="form-group row">
                <label for="tgl_mulai" class="col-3 col-lg-2 col-form-label text-right">Tanggal Mulai</label>
                <div class="col-6 col-lg-10">
                  <input id="tgl_mulai" type="text" name="tgl_mulai" data-parsley-type="tgl_mulai" placeholder="YYYY-MM-DD" class="form-control"  value="<?php echo $item->tgl_mulai;?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="tgl_mulai" class="col-3 col-lg-2 col-form-label text-right">Tanggal Selesai</label>
                <div class="col-6 col-lg-10">
                  <input id="tgl_selesai" type="text" name="tgl_selesai" data-parsley-type="tgl_selesai" placeholder="YYYY-MM-DD" class="form-control"  value="<?php echo $item->tgl_selesai;?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="tgl_mulai" class="col-3 col-lg-2 col-form-label text-right">Penanggung Jawab</label>
                <div class="col-3 col-lg-4">
                  <input id="pembuat" type="text" name="pembuat" data-parsley-type="pembuat" placeholder="Penanggung Jawab" class="form-control" required>
                </div>
              </div>
              <div class="form-group row">
                <label for="tgl_mulai" class="col-3 col-lg-2 col-form-label text-right"></label>
                <div class="col-3 col-lg-4">
                  <button type="button" class="btn btn-space btn-primary" id="btnSave"><i class="fa fa-save"></i> Simpan</button>
                    <a href="/stok_opname" class="btn btn-space btn-secondary"><i class="fa fa-arrow-left"></i> Batal</a>
                  </p>
                </div>
              </div>

              <?php echo form_close(); ?>
            </div>
          </div>
        </div>
      </div>
    </div>