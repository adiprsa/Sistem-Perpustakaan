<div class="modal" id="impModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Import <?=strtoupper($jenis);?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="form-horizontal">
      <div class="modal-body">
          <div class="form-group">
            <div class="col-md-2">
              <a href="<?= base_url('asset/template/template_bilio.xls')?>" class="btn btn-success">Unduh Template</a>
            </div>
            <div class="col-md-10">
              <input type="file" name="file">
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" onclick="simpanImport()">Simpan</button>
        <button class="btn" data-dismiss="modal">Batal</button>
      </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function simpanImport() {
    $.ajax({
      url: "<?=site_url('buku/import')?>",
      type: "POST",
      data:  new FormData(this),
      contentType: false,
          cache: false,
      processData:false,
      success: function(respon){
        if (respon.status == 'berhasil') {
                    alert(respon.alert);
          window.location.href = respon.link;
                } else {
                  alert(respon.alert);
          $("#modal_loader").hide();
                }
      },
        error: function() 
        {
        alert('Gagal simpan data');
        $("#modal_loader").hide();
        }         
     });
  };
</script>