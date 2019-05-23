<script>
    $(document).ready( function () {
        //Datatable
        $('#member').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": '<?php echo site_url('member/get_data_member'); ?>',
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [
            {
                "targets": [ 0 ], //first column / numbering column
                "orderable": false, //set not orderable
            },
            ],
        });

        //Form add member
        $("#tambah").click(function(){
            $('#tampil_form').load("<?=site_url()?>member/modal_form",function() {
                $('#modal_form').modal('show');
            });
        });

        //Download templates
        $("#download").click(function(e){
            e.preventDefault();
            window.location.href = '<?php echo site_url('member/download_template');?>';
        });

        //Import data member
        $("#import").click(function(e){
            $('#tampil_form').load("<?=site_url()?>member/modal_import",function() {
                $('#modal_form').modal('show');
            });
        });
    } );   

    //Form edit member
    $(document).on('click', '.ganti', function(){
        $('#tampil_form').load("<?=site_url()?>member/edit_form/"+$(this).attr('id'),function() {
            $('#modal_form').modal('show');
        });
    }); 

    //Form hapus member
    $(document).on('click', '.hapus', function(){
        var cnf = confirm("Apakah anda yakin akan menghapus member ini?");
        if (cnf == true) {
            $.post('<?=site_url()?>member/hapus/' + $(this).attr('id'), function() {
                alert('Tipe member berhasil dihapus');
                location.reload();
            });
        }
    }); 
</script>