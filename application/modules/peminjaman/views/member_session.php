<script>

function clear_input() {
  $("#item_code").val('');
  $("#item_code").focus();
}
function pinjam(){
  $.ajax({
    url: "<?=site_url('/peminjaman/pinjam')?>",
    type: "POST",
    beforeSend: function(result){
      $("#pinjam").html("<img src='<?=base_url('assets/loading/loadingImage.gif');?>' height='50' width='50'/>");
    },
    success: function(resp){
      $("#pinjam").html(resp);
    },
    error: function() {
      showMessage('error', '500', 'Terjadi Kegagalan Proses');
    }
  }).done(function() {
    $("#item_code").focus();
  });
}

function saat_ini(){
  $.ajax({
    url: "<?=site_url('/peminjaman/saat_ini')?>",
    type: "POST",
    beforeSend: function(result){
      $("#saat_ini").html("<img src='<?=base_url('assets/loading/loadingImage.gif');?>' height='50' width='50'/>");
    },
    success: function(resp){
      $("#saat_ini").html(resp);
    },
    error: function() {
      showMessage('error', '500', 'Terjadi Kegagalan Proses');
    }
  });
}

function sejarah(){
  $.ajax({
    url: "<?=site_url('/peminjaman/sejarah')?>",
    type: "POST",
    beforeSend: function(result){
      $("#sejarah").html("<img src='<?=base_url('assets/loading/loadingImage.gif');?>' height='50' width='50'/>");
    },
    success: function(resp){
      $("#sejarah").html(resp);
    },
    error: function() {
      showMessage('error', '500', 'Terjadi Kegagalan Proses');
    }
  });
}

$(document).ready(function (e) {
  $('#item_code').keypress(function(e){
    if(e.which == 13){
      $('#btnPinjam').click();
    }
  });
  $("#btnPinjam").on('click',(function(e) {
    e.preventDefault();
    var member_code = $('#member_code').val();
    var item_code = $('#item_code').val();
    if (item_code != '') {
      $.ajax({
        url: "<?=base_url('/peminjaman/pinjam_buku')?>",
        type: "POST",
        data:  {'item_code':item_code,'member_code':member_code},
        beforeSend: function(result){
          $('#btnPinjam').prop('disabled', true);
        },
        success: function(resp){
          var obj = JSON.parse(resp);
          showMessage(obj.type, obj.error_code, obj.messages);
          clear_input();
          $('#btnPinjam').prop('disabled', false);
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
      <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="card">
            <div class="card-body">
              <h4>Peminjaman Aktif</h4>
              <div class="input-group mb-3">
                  <a href="<?=base_url('/peminjaman/remove_session');?>" class="btn btn-large btn-danger">Selesaikan Peminjaman</a> &nbsp;
                  <a href="<?=base_url('/pengembalian');?>" class="btn btn-large btn-info">Pengembalian Buku</a>
              </div>
              <div id="detailMember" class="loading">
                <table>
                  <tr>
                    <td rowspan="6">
                      <img src="<?=base_url('assets/images/user_profile.png');?>"
                    </td>
                  </tr>
                  <tr>
                    <td>Kode Member: </td>
                    <td><strong><?php echo $this->session->member_code;?></strong></td>
                  </tr>
                  <tr>
                    <td>Nama Member: </td>
                    <td><strong><?php echo $this->session->nama_member;?></strong></td>
                  </tr>
                  <tr>
                    <td>Tgl Lahir: </td>
                    <td><strong><?php echo $this->session->tgl_lahir;?></strong></td>
                  </tr>
                  <tr>
                    <td>Tanggal Register: </td>
                    <td><strong><?php echo $this->session->tgl_register;?></strong></td>
                  </tr>
                  <tr>
                    <td>Tgl Expired: </td>
                    <td><strong><?php echo $this->session->tgl_expired;?></strong></td>
                  </tr>
                </table>
                <br>
                <div class="tab-regular">
                  <ul class="nav nav-tabs " id="myTab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="pinjam-tab" data-toggle="tab" href="#pinjam" onclick="javascript:pinjam();" role="tab" aria-controls="pinjam" aria-selected="true" cur>Peminjaman</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="saat_ini-tab" data-toggle="tab" href="#saat_ini" onclick="javascript:saat_ini();" role="tab" aria-controls="saat_ini" aria-selected="false">Pinjaman Saat Ini</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="sejarah-tab" data-toggle="tab" href="#sejarah" onclick="javascript:sejarah();" role="tab" aria-controls="sejarah" aria-selected="false">Sejarah Peminjaman</a>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active loading" id="pinjam" role="tabpanel" aria-labelledby="home-tab">
                      <div class="col-lg-3">
                        <div class="input-group mb-3">
                          <input type="text" class="form-control" id="item_code" autofocus>

                          <div class="input-group-append">
                            <button type="button" class="btn btn-success" id="btnPinjam">Pinjam Buku</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade loading" id="saat_ini" role="tabpanel" aria-labelledby="profile-tab">

                    </div>
                    <div class="tab-pane fade loading" id="sejarah" role="tabpanel" aria-labelledby="contact-tab">

                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
