<!-- ============================================================== -->
<!-- wrapper  -->
<!-- <script src="<?= base_url('assets/datatable') ?>/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="<?= base_url('assets/datatable') ?>/dataTables.bootstrap.min.css"> -->

<script>

  function getItem() {
    $.ajax({
          url: "<?= base_url('/stok_opname_item/items') ?>",
          type: "GET",
          data: {
          },
          beforeSend: function(result) {
            $("#detailProses").html("<img src='<?= base_url('assets/loading/loadingImage.gif'); ?>' height='50' width='50'/>");
          },
          success: function(resp) {
            $("#detailProses").html(resp);
          },
          error: function() {
            showMessage('error', '500', 'Terjadi Kegagalan Proses');
          }
        });
  }

  $(document).ready(function(e) {
    getItem();
    $('#item_code').keypress(function(e) {
      if (e.which == 13) {
        $('#btnProses').click();
      }
    });
    // $('#status').keypress(function(e) {
    //   if (e.which == 13) {
    //     $('#btnProses').click();
    //   }
    // });
    $("#prosesData").on('click', (function(e) {
      e.preventDefault();
      var item_code = $('#item_code').val();
      var status = $('#status').val();
      if (item_code != '' && status != '') {
        $.ajax({
          url: "<?= base_url('/stok_opname_item/proses') ?>",
          type: "POST",
          data: {
            'item_code': item_code,
            'status':status
          },
          beforeSend: function(result) {
            $('#prosesData').prop('disabled', true);
            $("#detailProses").html("<img src='<?= base_url('assets/loading/loadingImage.gif'); ?>' height='50' width='50'/>");
          },
          success: function(resp) {
            var obj = JSON.parse(resp);
            showMessage(obj.type, obj.error_code, obj.messages);
            $("#detailProses").html('');
            $("#item_code").val('');
            $("#item_code").focus();
            $('#prosesData').prop('disabled', false);
            getItem();
          },
          error: function() {
            showMessage('error', '500', 'Terjadi Kegagalan Proses');
          }
        });
      }
    }));
  });
</script>


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
        <!-- ============================================================== -->
        <!-- data table  -->
        <!-- ============================================================== -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="card">
            <div class="card-header">
              <div class="col-md-12">
                <div class="container">
                  <div class="row" style="height: 50px;padding-top: 15px">
                    <div class="col-sm">
                      Nama Stok Opname: <strong><?php echo $this->stok_opname->nama_stok_opname; ?></strong>
                    </div>
                    <div class="col-sm">
                      Tanggal Mulai: <strong><?php echo $this->stok_opname->tgl_mulai; ?></strong>
                    </div>
                    <div class="col-sm">
                      Tanggal Selesai: <strong><?php echo $this->stok_opname->tgl_selesai; ?></strong>
                    </div>
                    <div class="col-sm">
                      Penanggung Jawab: <strong><?php echo $this->stok_opname->nama_pembuat; ?></strong>
                    </div>
                   
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-body">
                <div class="col-md-12">
                    <div class="form-group row">
                      <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right">Kode Buku</label>
                      <div class="col-4 col-lg-5">
                        <input id="item_code" type="text" placeholder="Kode Buku" class="form-control" autofocus>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputWebSite" class="col-3 col-lg-2 col-form-label text-right">Status Buku</label>
                      <div class="col-4 col-lg-5">
                        <select name="status" id="status" class="form-control">
                          <?php 

                              

                              if (is_array($status)) {
                                foreach ($status as $val) {
                                  if($val->item_status_id==1) {
                                    $checked = 'checked';
                                  }
                                  echo "<option value=$val->item_status_id $checked>$val->nama_status</option>" ;
                                }
                              }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputWebSite" class="col-3 col-lg-2 col-form-label text-right"></label>
                      <div class="col-4 col-lg-5">
                      <button type="button" class="btn btn-space btn-primary" id="prosesData">Proses Buku</button>
                      </div>
                    </div>
     
                </div>
                
              </div>
              <div class="col-md-12" id="detailProses" style="margin-top:50px"></div>
            </div>
          </div>
        </div>
        <!-- ============================================================== -->
        <!-- end data table  -->
        <!-- ============================================================== -->
      </div>
    </div>
  </div>
</div>