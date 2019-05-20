<script>
  function clear_input() {
    $("#item_code").val('');
    $("#item_code").focus();
  }

  function sejarah() {
    $.ajax({
      url: "<?= site_url('/denda/sejarah') ?>",
      type: "POST",
      beforeSend: function(result) {
        $("#sejarah").html("<img src='<?= base_url('assets/loading/loadingImage.gif'); ?>' height='50' width='50'/>");
      },
      success: function(resp) {
        $("#sejarah").html(resp);
      },
      error: function() {
        showMessage('error', '500', 'Terjadi Kegagalan Proses');
      }
    });
  }

  $(document).ready(function(e) {
    $("#checkAll").click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $("#btnBayar").on('click', (function(e) {
      e.preventDefault();
      var id = [];
      $('input.tagihan_id:checkbox:checked').each(function () {
          id.push($(this).val());
      });
      
      if (id != '') {
        $.ajax({
          url: "<?= base_url('/denda/bayar') ?>",
          type: "POST",
          data: {
            'id': id,
          },
          beforeSend: function(result) {
            $('#btnBayar').prop('disabled', true);
          },
          success: function(resp) {
            var obj = JSON.parse(resp);
            showMessage(obj.type, obj.error_code, obj.messages);
            $('#btnKembali').prop('disabled', false);
            setTimeout(function(){ window.location.reload(); }, 1500);
          },
          error: function() {
            showMessage('error', '500', 'Terjadi Kegagalan Proses');
          }
        });
      }
    }));
  });
</script>

<div class="dashboard-wrapper">
  <div class="dashboard-ecommerce">
    <div class="container-fluid dashboard-content ">
      <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="card">
            <div class="card-body">
              <h4>Member Aktif</h4>
              <div class="input-group mb-3">
                <a href="<?= base_url('/denda/remove_session'); ?>" class="btn btn-large btn-danger">Selesaikan Transaksi</a>
              </div>
              <div id="detailMember" class="loading">
                <table>
                  <tr>
                    <td rowspan="6">
                      <img src="<?= base_url('assets/images/user_profile.png'); ?>" </td> </tr> <tr>
                    <td>Kode Member: </td>
                    <td><strong><?php echo $this->session->member_code; ?></strong></td>
                  </tr>
                  <tr>
                    <td>Nama Member: </td>
                    <td><strong><?php echo $this->session->nama_member; ?></strong></td>
                  </tr>
                  <tr>
                    <td>Tgl Lahir: </td>
                    <td><strong><?php echo $this->session->tgl_lahir; ?></strong></td>
                  </tr>
                  <tr>
                    <td>Tanggal Register: </td>
                    <td><strong><?php echo $this->session->tgl_register; ?></strong></td>
                  </tr>
                  <tr>
                    <td>Tgl Expired: </td>
                    <td><strong><?php echo $this->session->tgl_expired; ?></strong></td>
                  </tr>
                </table>
                <br>
                <div class="tab-regular">
                  <ul class="nav nav-tabs " id="myTab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="pinjam-tab" data-toggle="tab" href="#pinjam" role="tab" aria-controls="pinjam" aria-selected="true" cur>Pembayaran Denda</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="sejarah-tab" data-toggle="tab" href="#sejarah" onclick="javascript:sejarah();" role="tab" aria-controls="sejarah" aria-selected="false">History Pembayaran</a>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active loading" id="pinjam" role="tabpanel" aria-labelledby="home-tab">
                    <?php
                    
                    if(is_array($items)) {
                    ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered first">
                          <thead>
                            <tr>
                              <th style="text-align:center">
                                  <input type="checkbox" id="checkAll">
                                </td>
                              </th>
                              <th>No</th>
                              <th>Kode Eksemplar</th>
                              <th>Judul</th>
                              <th>Tanggal Pinjam</th>
                              <th>Tanggal Kembali</th>
                              <th>Telat</th>
                              <th>Denda</th>
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
                                  <td style="text-align:center">
                                    <input type="checkbox" class="tagihan_id" value="<?php echo $item->pembnayaran_id;?>">
                                  </td>
                                  <td><?php echo $i; ?></td>
                                  <td><?php echo $item->no_item; ?></td>
                                  <td><?php echo $item->judul; ?></td>
                                  <td><?php echo $item->tgl_pinjam; ?></td>
                                  <td><?php echo $item->tgl_kembali; ?></td>
                                  <td><?php echo $this->aturan->get_lama_pinjam($item->tgl_kembali,$item->tgl_harus_kembali); ?> Hari</td>
                                  <td><?php echo $this->aturan->rupiah($item->total_denda); ?></td>
                                </tr>
                                <?php $i++;
                                }  ?>
                              <tfooter>
                            <tr>
                              <th></th>
                              <th colspan="6" style="text-align:right">Total</th>
                              <th colspan="1"><?php echo $this->aturan->rupiah(array_sum($total_denda));?></th>
                            </tr>
                          </tfooter>
                        </table>
                        <br>
                        <button type="button" class="btn btn-primary" id="btnBayar">Bayar Denda</button>
                      </div>
                      <?php
                    }
                    ?>
                    </div>
                    <div class="tab-pane fade loading" id="sejarah" role="tabpanel" aria-labelledby="contact-tab">

                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>