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
							    			<td><select class="form-control judul" name="judul"></select></td>
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
  placeholder: 'Cari buku',
  escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
  minimumInputLength: 1,
  templateResult: formatRepo,
  templateSelection: formatRepoSelection
});

function formatRepo (repo) {
  if (repo.loading) {
    return 'loading';
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
  return repo.id+"_"+repo.judul;
}
</script>
<style type="text/css">
  
.select2-result-repository {
 padding-top:4px;
 padding-bottom:3px
}
.select2-result-repository__avatar {
 float:left;
 width:60px;
 margin-right:10px
}
.select2-result-repository__avatar img {
 width:100%;
 height:auto;
 border-radius:2px
}
.select2-result-repository__meta {
 margin-left:70px
}
.select2-result-repository__title {
 color:black;
 font-weight:700;
 word-wrap:break-word;
 line-height:1.1;
 margin-bottom:4px
}
.select2-result-repository__forks,
.select2-result-repository__stargazers {
 margin-right:1em
}
.select2-result-repository__forks,
.select2-result-repository__stargazers,
.select2-result-repository__watchers {
 display:inline-block;
 color:#aaa;
 font-size:11px
}
.select2-result-repository__description {
 font-size:13px;
 color:#777;
 margin-top:4px
}
.select2-results__option--highlighted .select2-result-repository__title {
 color:white
}
.select2-results__option--highlighted .select2-result-repository__forks,
.select2-results__option--highlighted .select2-result-repository__stargazers,
.select2-results__option--highlighted .select2-result-repository__description,
.select2-results__option--highlighted .select2-result-repository__watchers {
 color:#c6dcef
}
.s2-docs-sidebar.affix {
 position:static
}
</style>