<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
<script src="<?php echo base_url('assets/vendor/datetimepicker/jquery.min.js');?>"></script>
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.min.css')?>">
    <link href="<?php echo base_url('assets/vendor/fonts/circular-std/style.css')?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/libs/css/style.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/fonts/fontawesome/css/fontawesome-all.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/charts/chartist-bundle/chartist.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/charts/morris-bundle/morris.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/charts/c3charts/c3.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/toastr/toastr.min.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/fonts/flag-icon-css/flag-icon.min.css')?>">
    <link href="<?php echo base_url('assets/vendor/datetimepicker/bootstrap-datetimepicker.css');?>" rel="stylesheet"/>
    <!-- <link rel="stylesheet" href="<?=base_url('assets/vendor/datetimepicker/bootstrap-datetimepicker.css');?>"> -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/datatables/css/buttons.bootstrap4.css')?>">
    <!-- jquery 3.3.1
    <script src="<?php echo base_url('assets/vendor/jquery/jquery-3.3.1.min.js') ?>"></script>
	-->
    <script src="<?php echo base_url('assets/plugins/toastr/toastr.min.js') ?>"></script>
    
<!-- bootstap bundle js -->
<script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.bundle.js') ?>"></script>
<!-- slimscroll js -->
<script src="<?php echo base_url('assets/vendor/slimscroll/jquery.slimscroll.js') ?>"></script>
<!-- main js -->
<script src="<?php echo base_url('assets/libs/js/main-js.js') ?>"></script>
<!-- chart chartist js -->
<script src="<?php echo base_url('assets/vendor/charts/chartist-bundle/chartist.min.js') ?>"></script>
<!-- sparkline js -->
<script src="<?php echo base_url('assets/vendor/charts/sparkline/jquery.sparkline.js') ?>"></script>
<!-- morris js -->
<script src="<?php echo base_url('assets/vendor/charts/morris-bundle/raphael.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/charts/morris-bundle/morris.js') ?>"></script>
<!-- chart c3 js -->
<script src="<?php echo base_url('assets/vendor/charts/c3charts/c3.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/charts/c3charts/d3-5.4.0.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/charts/c3charts/C3chartjs.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/datetimepicker/moment-with-locales.js');?>"></script>
<script src="<?php echo base_url('assets/vendor/datetimepicker/bootstrap-datetimepicker.js');?>"></script>
<!-- <script src="assets/libs/js/dashboard-ecommerce.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-datatable/jquery.dataTables.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-datatable/extensions/export/jszip.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-datatable/extensions/export/pdfmake.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-datatable/extensions/export/vfs_fonts.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-datatable/extensions/export/buttons.print.min.js') ?>"></script>
-->
<script type="text/javascript">
    $(document).ready(function() {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "positionClass": "toast-top-center",
            "onclick": null,
            "showDuration": "1000",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
            }
        });

        function showMessage(type, error_code, messages) {
            toastr[type](error_code + ' - '+messages);
        }
</script>

    

    
    <title>PERPUSTAKAAN</title>
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" href="<?=site_url()?>">PERPUSTAKAAN</a>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="assets/images/avatar-1.jpg" alt="" class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name"><?=$this->session->userdata('username')?> </h5>
                                </div>
                                <a class="dropdown-item" href="#" id='acc_setting'><i class="fas fa-cog mr-2"></i>Setting</a>
                                <a class="dropdown-item" href="<?=site_url('login/logout')?>"><i class="fas fa-power-off mr-2"></i>Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
		<div id="modalmain_form" class="modal" data-width="600">
	<div id="tampilmain_form"></div>
</div>
<script>
$(document).on('click','#acc_setting',function(){
	$('#tampilmain_form').load("<?=site_url()?>user/modal_myform",function(){
	$('#modalmain_form').modal('show');
	});
});

</script>

        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <?php $this->load->view('templates/sidebar') ?>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
