<script type="text/javascript">
  $(document).ready(function() {
    // $('#responsive-datatable').DataTable({
    //   "pageLength": 25
    // });

    $(function () {
        $('#tgl_mulai').datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $('#tgl_mulai').datetimepicker({
            format: 'DD-MM-YYYY'
        });
    });

  });

</script>
<!-- ============================================================== -->
<div class="dashboard-wrapper">
  <div class="dashboard-ecommerce">
    <div class="container-fluid dashboard-content ">
    <!-- ============================================================== -->
			<!-- pageheader  -->
			<!-- ============================================================== -->
			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="page-header">
						<h2 class="pageheader-title"><?=$title?> </h2>
						<div class="page-breadcrumb">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">Dashboard</a></li>
									<li class="breadcrumb-item active" aria-current="page"><?=$title?></li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
			</div>
			<!-- ============================================================== -->
			<!-- end pageheader  -->
			<!-- ============================================================== -->
      <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="card">
            <div class="card">
              <h5 class="card-header"><a href="<?=base_url($link_add);?>" class="btn btn-primary"><i class="fa fa-plus"></i>  Tambah Data</a></h5>
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Nama Stok Opname</th>
                      <th scope="col">Tanggal Mulai</th>
                      <th scope="col">Tanggal Selesai</th>
                      <th scope="col">Penanggung Jawab</th>
                      <th scope="col">Status Aktif</th>
                      <th scope="col">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      $i = 1;
                      if(is_array($items)){
                          foreach ($items as $item) {
                              if ($item->is_active == 1) {
                                $status = "Aktif";
                              } else {
                                $status = 'Tidak Aktif';
                              }
                          ?>
                        <tr>
                          <th scope="row"><?php echo $i;?></th>
                          <td><?php echo $item->nama_stok_opname;?></td>
                          <td><?php echo $item->tgl_mulai;?></td>
                          <td><?php echo $item->tgl_selesai;?></td>
                          <td><?php echo $item->nama_pembuat;?></td>
                          <td><?php echo $status;?></td>
                          <td>
                            <a href="<?=base_url('stok_opname/edit/'.$item->stok_opname_id);?>" class="btn btn-warning">
                              Edit</a> &nbsp; 
                              <a href="<?=base_url('stok_opname/edit/'.$item->stok_opname_id);?>" class="btn btn-danger">
                              Hapus</a> 
                          </td>
                        </tr>
                      <?php $i++; } }  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>