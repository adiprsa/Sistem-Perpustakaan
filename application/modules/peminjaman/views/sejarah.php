<div class="table-responsive">
  <table class="table table-striped table-bordered first">
    <thead>
      <tr>
        <th>No</th>
        <th>Kode Eksemplar</th>
        <th>Judul</th>
        <th>Tipe Koleksi</th>
        <th>Tanggal Pinjam</th>
        <th>Tanggal Kembali</th>
        <th>Denda</th>
        <th>Status Bayar</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $i = 1;
      foreach ($items as $item) {
      if($item->tgl_bayar!='') {
        $bayar = '<span style="color: #5cb85c">Lunas</span>';
      } else {
        $bayar = '<span style="color: #f0ad4e">Belum Bayar</span>';
      }
      ?>
      <tr>
        <td><?php echo $i;?></td>
        <td><?php echo $item->no_item;?></td>
        <td><?php echo $item->judul;?></td>
        <td><?php echo $item->kolasi;?></td>
        <td><?php echo $item->tgl_pinjam;?></td>
        <td><?php echo $item->tgl_kembali;?></td>
        <td><?php echo $this->aturan->rupiah($item->total_denda);?></td>
        <td><?php echo $bayar;?></td>
      </tr>
    <?php $i++; }?>
  </table>
</div>
