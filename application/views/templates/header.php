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
    <!-- jquery 3.3.1 -->
    <script src="<?php echo base_url('assets/vendor/jquery/jquery-3.3.1.min.js') ?>"></script>
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
<script src="<?php echo base_url('assets/vendor/datetimepicker/jquery.min.js');?>"></script>
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

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/css/bootstrap-modal.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modal.js"></script>

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
                <a class="navbar-brand" href="index.html">PERPUSTAKAAN</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </nav>
        </div>
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
