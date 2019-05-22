<!-- ============================================================== -->
<!-- wrapper  -->
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
									<li class="breadcrumb-item"><a href="<?=base_url($title)?>" class="breadcrumb-link"><?=$title?></a></li>
									<li class="breadcrumb-item active" aria-current="page"><?=$action.' '.$title?></li>
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
						<div class="card-header">
							<h4><?=strtoupper($action." ".$title);?></h4>
						</div>
						<div class="card-body">
                            <div class="table-responsive">
                                <form method="post">
							    	<table class="table">
							    		<tr>
							    			<td width="30%">Judul Buku</td>
							    			<td><select class="form-control judul"></select></td>
							    		</tr>							    		
							    	</table>
							    	<input type="submit" value="Lihat" class="btn btn-primary" >
							    </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>

<link rel="stylesheet" type="text/css" href="<?=base_url('assets/plugins/select2/css/select2.min.css')?>">
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/plugins/select2/css/select2.cari.css')?>">
<script type="text/javascript" src="<?=base_url('assets/plugins/select2/js/select2.min.js')?>"></script>
<script type="text/javascript">

$(".judul").select2({
  ajax: {
    url: "<?=site_url('buku/ajax/cari_buku')?>",
    dataType: 'json',
    delay: 250,
    data: function (params) {
      return {
        q: params.term, // search term
        page: params.page
      };
    },
    processResults: function (data, params) {
      // parse the results into the format expected by Select2
      // since we are using custom formatting functions we do not need to
      // alter the remote JSON data, except to indicate that infinite
      // scrolling can be used
      params.page = params.page || 1;

      return {
        results: data.items,
        pagination: {
          more: (params.page * 30) < data.total_count
        }
      };
    },
    cache: true
  },
  placeholder: 'Search for a repository',
  escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
  minimumInputLength: 1,
  templateResult: formatRepo,
  templateSelection: formatRepoSelection
});

function formatRepo (repo) {
  if (repo.loading) {
    return repo.text;
  }

  var markup = "<div class='select2-result-repository clearfix'>" +
    "<div class='select2-result-repository__avatar'>" + 
      "<img src='<?=base_url('assets/images/avatar-1.jpg')?>' /></div>" +
    "<div class='select2-result-repository__meta'>" +
      "<div class='select2-result-repository__title'>" + repo.judul + "</div>" +
      "<div class='select2-result-repository__description'>" + repo.penerbit + "</div>"+
    "</div></div>";

  return markup;
}

function formatRepoSelection (repo) {
  return repo.full_name || repo.text;
}
</script>