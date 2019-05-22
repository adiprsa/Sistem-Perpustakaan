<!-- ============================================================== -->
<!-- wrapper  -->
<!-- <script src="<?= base_url('assets/datatable') ?>/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="<?= base_url('assets/datatable') ?>/dataTables.bootstrap.min.css"> -->

<script>
$(document).ready(function (e) {
  $('#member_code').keypress(function(e){
        if(e.which == 13){
            $('#find_member').click();
        }
    });
  $("#find_member").on('click',(function(e) {
    e.preventDefault();
    var member_code = $('#member_code').val();
    if (member_code != '') {
      $.ajax({
        url: "<?=base_url('/peminjaman/find_member')?>",
        type: "POST",
        data:  {'member_code':member_code},
        beforeSend: function(result){
          $('#find_member').prop('disabled', true);
          $("#detailMember").html("<img src='<?=base_url('assets/loading/loadingImage.gif');?>' height='50' width='50'/>");
        },
        success: function(resp){
          if(resp=='404') {
            showMessage('warning', '404', 'Member ID tidak ditemukan');
            $("#detailMember").html('');
            $("#member_code").val('');
            $("#member_code").focus();
          } else {
            $("#detailMember").html(resp);
            $('#find_member').prop('disabled', false);
            $("#item_code").focus();
          }

        },
        error: function() {
          showMessage('error', '500', 'Terjadi Kegagalan Proses');
        }
      });
    }
  }));
});
</script>


<!-- ============================================================== -->
<div class="dashboard-wrapper">
  <div class="dashboard-ecommerce">
    <div class="container-fluid dashboard-content ">
      <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="card">
            <div class="card-body">
              <h4>Ketik atau Scan ID Member</h4>
                <div class="input-group mb-3">
                  <input type="text" class="form-control col-md-2" id="member_code" autofocus>
                  <div class="input-group-append">
                    <button type="button" class="btn btn-primary" id="find_member">Cari Data</button>
                  </div>
                </div>
              <div id="detailMember" class="loading"></div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
