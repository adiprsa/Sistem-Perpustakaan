<script>
    $(document).ready( function () {
        //Datatable
        $('#member').DataTable({
            "ajax": {
                url : "<?=site_url()?>member/ajaxdatatable",
                type : 'GET'
            },
        });

        //Form add member
        $("#tambah").click(function(){
            $('#tampil_form').load("<?=site_url()?>member/modal_form",function() {
                $('#modal_form').modal('show');
            });
        });

        //Form edit tipe member
        $(".ganti").click(function(){
            $('#tampil_form').load("<?=site_url()?>member/modal_form/"+$(this).attr('id'),function() {
                $('#modal_form').modal('show');
            });
        });

        $(".hapus").click(function(){
            var cnf = confirm("Apakah anda yakin akan menghapus tipe member ini?");
            if (cnf == true) {
                $.post('<?=site_url()?>member/hapus/' + $(this).attr('id'), function() {
                    alert('Tipe member berhasil dihapus');
                    location.reload();
                });
            }
        });

    } );    
</script>