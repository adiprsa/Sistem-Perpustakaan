
<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=base_url()?>/assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="<?=base_url()?>/assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url()?>/assets/libs/css/style.css">
    <link rel="stylesheet" href="<?=base_url()?>/assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <style>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }
    </style>
</head>

<body>
    <!-- ============================================================== -->
    <!-- login page  -->
    <!-- ============================================================== -->
    <div class="splash-container">
        <div class="card ">
            <div class="card-header text-center"><a href="<?=base_url()?>/index.html"><img class="logo-img" width='100px' height='auto' src="<?=base_url()?>assets/udinus_logo.png" alt="logo"></a><span class="splash-description">Perpustakaan Udinus.</span></div>
            <div class="card-body">
                <form id='login'>
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="username" type="text" placeholder="Username" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="password" type="password" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
                </form>
            </div>
            <div class="card-footer bg-white p-0  ">
                </div>
            </div>
        </div>
    </div>
	
    <!-- ============================================================== -->
    <!-- end login page  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="<?=base_url()?>/assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="<?=base_url()?>/assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
	<script>
	$(document).ready(function (e) {
		$("#login").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
		  url: "<?=site_url()?>/Login/proses",
		  type: "POST",
		  data:  new FormData(this),
		  contentType: false,
		  cache: false,
		  dataType: 'json',
		  processData:false,
		  success: function(respon){
			if (respon.status == 'berhasil') {
				  alert(respon.alert);
				  window.location.href = respon.link;                 
				} else {
				  alert(respon.alert);
				}
			},
		  error: function() 
		  {
			alert('Gagal simpan data');
		  }         
		 });
	  }));
	});
	</script>
</body>
 
</html>