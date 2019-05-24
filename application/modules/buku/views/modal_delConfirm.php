<div class="modal" id="delModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">PERINGATAN HAPUS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Apakah anda yakin ingin menghapus <?=$tabel." ".$nama;?>?</p>
      </div>
      <div class="modal-footer">
        <a href="javascript:void(0)" class="btn" onclick="yakinHapus('<?=$id;?>')">Ya</a>
        <a href="javascript:void(0)" class="btn btn-danger" data-dismiss="modal">Batal</a>
      </div>
    </div>
  </div>
</div>