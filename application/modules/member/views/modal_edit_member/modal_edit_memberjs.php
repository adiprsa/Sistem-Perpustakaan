<!-- bootstap datepicker js -->
<script src="<?php echo base_url('assets/vendor/datepicker/moment.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/datepicker/tempusdominus-bootstrap-4.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/datepicker/datepicker.js') ?>"></script>

<script>
	$(document).ready( function () {
        $.ajaxSetup({
            type:"POST",
            url: "<?php echo site_url('member/ajaxprodi_edit'); ?>",
            cache: false
        });

        $("#fakultas").change(function(){
            var value=$(this).children(":selected").val();
            if(value!=0) {
                $.ajax({
                    data:{id:value},
                    success: function(respond){
                        $("#prodi").html(respond);
                    }
                });
            }
        });

        $("form").submit(function(event){
			event.preventDefault();
			$("#modal_loader").show();
			$.post(
				"<?php echo site_url('member/update_member');?>", 
				$(this).serialize(), 
				function(response) {
					var response = jQuery.parseJSON(response);

					if(response.status == 'berhasil') {
						alert(response.alert);
						location.reload();
					} else {
						alert(response.alert);
						$("#modal_loader").hide();
					}
				}
			);
		});
    });
</script>
<div id="modal_loader" class="modal" data-width="600">
	<div class="loader"></div>
</div>
<style>
	#modal_loader {
		position: absolute;
		left: 50%;
		top: 50%;
		z-index: 1;
		width: 150px;
		height: 150px;
		margin: -75px 0 0 -75px;
		border: 16px solid #f3f3f3;
		border-radius: 50%;
		border-top: 16px solid #3498db;
		width: 120px;
		height: 120px;
		-webkit-animation: spin 2s linear infinite;
		animation: spin 2s linear infinite;
	}

	/* Safari */
	@-webkit-keyframes spin {
		0% { -webkit-transform: rotate(0deg); }
		100% { -webkit-transform: rotate(360deg); }
	}

	@keyframes spin {
		0% { transform: rotate(0deg); }
		100% { transform: rotate(360deg); }
	}
</style>