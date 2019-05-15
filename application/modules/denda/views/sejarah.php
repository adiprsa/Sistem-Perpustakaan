<div class="table-responsive">
  <table class="table table-striped table-bordered first">
    <thead>
      <tr>
        <th>No</th>
        <th>Kode Eksemplar</th>
        <th>Judul</th>
        <th>Tanggal Pinjam</th>
        <th>Tanggal Kembali</th>
        <th>Telat</th>
        <th>Denda</th>
        <th>Tanggal Bayar</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $i = 1;
      $total_denda = [];
      foreach ($items as $item) {
        $total_denda[$i] = $item->total_denda;
        ?>
        <tr>
          <td><?php echo $i; ?></td>
          <td><?php echo $item->no_item; ?></td>
          <td><?php echo $item->judul; ?></td>
          <td><?php echo $item->tgl_pinjam; ?></td>
          <td><?php echo $item->tgl_kembali; ?></td>
          <td><?php echo $this->aturan->get_lama_pinjam($item->tgl_kembali, $item->tgl_harus_kembali); ?> Hari</td>
          <td><?php echo $this->aturan->rupiah($item->total_denda); ?></td>
          <td><?php echo $item->tgl_bayar; ?></td>
        </tr>
        <?php $i++;
      } ?>
      <tfooter>
        <tr>
          <th></th>
          <th colspan="6" style="text-align:right">Total</th>
          <th colspan="1"><?php echo $this->aturan->rupiah(array_sum($total_denda)); ?></th>
        </tr>
      </tfooter>
  </table>
</div>