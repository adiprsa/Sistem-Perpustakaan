
    </div>
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    <div class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                   Copyright © 2018 Concept. All rights reserved. Dashboard by <a href="https://colorlib.com/wp/">Colorlib</a>.
               </div>
               <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="text-md-right footer-links d-none d-sm-block">
                    <a href="javascript: void(0);">About</a>
                    <a href="javascript: void(0);">Support</a>
                    <a href="javascript: void(0);">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- end footer -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- end wrapper  -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- end main wrapper  -->
<!-- ============================================================== -->
<!-- Optional JavaScript -->
<!-- jquery 3.3.1 -->
<script src="<?php echo base_url('assets/vendor/jquery/jquery-3.3.1.min.js') ?>"></script>

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


</body>

</html>