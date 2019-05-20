<div class="table-responsive">
  <table class="table table-striped table-bordered first">
    <thead>
      <tr>
        <th>No</th>
        <th>Kode Buku</th>
        <th>Judul</th>
        <th>Status</th>
        <th>pengecek</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $i = 1;
      foreach ($items as $item) {
      ?>
      <tr>
        <td><?php echo $i;?></td>
        <td><?php echo $item->item_code;?></td>
        <td><?php echo $item->judul;?></td>
        <td><?php echo $item->status;?></td>
        <td><?php echo $item->pengecek;?></td>
      </tr>
    <?php $i++; }?>
  </table>
</div>
