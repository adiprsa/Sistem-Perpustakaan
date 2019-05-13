<div class="table-responsive">
  <table class="table table-striped table-bordered first">
    <thead>
      <tr>
        <th>Aksi</th>
        <th>Kode Eksemplar</th>
        <th>Judul</th>
        <th>Tipe Koleksi</th>
        <th>Tanggal Pinjam</th>
        <th>Tanggal Harus Kembali</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($items as $item) {
      ?>
      <tr>
        <td><?php echo $item->peminjaman_id;?></td>
        <td><?php echo $item->no_item;?></td>
        <td><?php echo $item->judul;?></td>
        <td><?php echo $item->kolasi;?></td>
        <td><?php echo $item->tgl_pinjam;?></td>
        <td><?php echo $item->tgl_harus_kembali;?></td>
      </tr>
    <?php }?>
  </table>
</div>
