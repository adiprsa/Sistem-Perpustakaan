<div class="modal" id="delModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?=strtoupper($action." ".$tabel);?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" class="form-horizontal" action="<?=site_url('buku/'.$tabel.'/form/'.$action)?>">
      <div class="modal-body">
          <div class="form-group">
            <label class="control-label">Kategori </label>
            <input type="text" name="nama_kategori" class="form-control" placeholder="Kategori" value="<?=isset($kategori)?$kategori['nama_kategori']:'';?>">
            <?=isset($kategori)?"<input type='hidden' name='id' value='".$kategori['kategori_id']."'>":"";?>
          </div>
          <div class="form-group">
            <label class="control-label">Kode </label>
            <input type="text" name="kode_kategori" class="form-control" placeholder="kode" value="<?=isset($kategori)?$kategori['kode_kategori']:'';?>">
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <button class="btn" data-dismiss="modal">Batal</button>
      </div>
      </form>
    </div>
  </div>
</div>