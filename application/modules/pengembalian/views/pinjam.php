<script>
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
          alert(obj.error_code+ ' - '+obj.messages);
          clear_input();
          $('#btnKembali').prop('disabled', false);
        },
        error: function() {
          alert('Gagal simpan data');
        }
      });
    }
  }));
});
</script>
<div class="col-lg-4">
  <div class="input-group mb-4">
    <input type="text" class="form-control" id="item_code" autofocus>

    <div class="input-group-append">
      <button type="button" class="btn btn-success" id="btnKembali">Kembalikan Buku</button>
    </div>
  </div>
</div>
