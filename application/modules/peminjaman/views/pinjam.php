<script>
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
          alert(obj.error_code+ ' - '+obj.messages);
          clear_input();
          $('#btnPinjam').prop('disabled', false);
        },
        error: function() {
          alert('Gagal simpan data');
        }
      });
    }
  }));
});
</script>
<div class="col-lg-3">
  <div class="input-group mb-3">
    <input type="text" class="form-control" id="item_code" autofocus>

    <div class="input-group-append">
      <button type="button" class="btn btn-success" id="btnPinjam">Pinjam Buku</button>
    </div>
  </div>
</div>
