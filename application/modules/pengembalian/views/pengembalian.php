<script>

function clear_input() {
  $("#item_code").val('');
  $("#item_code").focus();
}
function pinjam(){
  $.ajax({
    url: "<?=site_url('/pengembalian/pinjam')?>",
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
    url: "<?=site_url('/pengembalian/saat_ini')?>",
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
    url: "<?=site_url('/pengembalian/sejarah')?>",
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
      $('#btnKembali').click();
    }
  });
  $("#btnKembali").on('click',(function(e) {
    e.preventDefault();
    var member_code = $('#member_code').val();
    var item_code = $('#item_code').val();
    if (item_code != '') {
      $.ajax({
        url: "<?=base_url('/pengembalian/return_buku')?>",
        type: "POST",
        data:  {'item_code':item_code,'member_code':member_code},
        beforeSend: function(result){
          $('#btnKembali').prop('disabled', true);
        },
        success: function(resp){
          var obj = JSON.parse(resp);
          showMessage(obj.type, obj.error_code, obj.messages);
          clear_input();
          $('#btnKembali').prop('disabled', false);
        },
        error: function() {
          showMessage('error', '500', 'Terjadi Kegagalan Proses');
        }
      });
    }
  }));
});
</script>

<table>
  <tr>
    <td rowspan="6">
      <img src="<?=base_url('assets/images/user_profile.png');?>"
    </td>
  </tr>
  <tr>
    <td>Kode Member: </td>
    <td><strong><?php echo $member->member_code;?></strong></td>
  </tr>
  <tr>
    <td>Nama Member</td>
    <td><strong><?php echo $member->nama_member;?></strong></td>
  </tr>
  <tr>
    <td>Tgl Lahir</td>
    <td><strong><?php echo $member->tgl_lahir;?></strong></td>
  </tr>
  <tr>
    <td>Tanggal Register</td>
    <td><strong><?php echo $member->tgl_register;?></strong></td>
  </tr>
  <tr>
    <td>Tgl Expired</td>
    <td><strong><?php echo $member->tgl_expired;?></strong></td>
  </tr>
</table>
<br>
<div class="tab-regular">
  <ul class="nav nav-tabs " id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="pinjam-tab" data-toggle="tab" href="#pinjam" onclick="javascript:pinjam();" role="tab" aria-controls="pinjam" aria-selected="true" cur>Pengembalian</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="saat_ini-tab" data-toggle="tab" href="#saat_ini" onclick="javascript:saat_ini();" role="tab" aria-controls="saat_ini" aria-selected="false">Pinjaman Saat Ini</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="sejarah-tab" data-toggle="tab" href="#sejarah" onclick="javascript:sejarah();" role="tab" aria-controls="sejarah" aria-selected="false">Sejarah pengembalian</a>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active loading" id="pinjam" role="tabpanel" aria-labelledby="home-tab">
      <div class="col-lg-4">
        <div class="input-group mb-4">
          <input type="text" class="form-control" id="item_code" autofocus>

          <div class="input-group-append">
            <button type="button" class="btn btn-success" id="btnKembali">Kembalikan Buku</button>
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
