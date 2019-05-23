<script>
    $(document).ready( function () {
        //Datatable
        $('#tipe-member').DataTable({
            "order" : [[0, 'asc']],
            "columnDefs": [
                { "targets": [5], "orderable": false }
            ]
        });

        //Form add tipe member
        $("#tambah").click(function() {
            $('#tampil_form').load("<?=site_url()?>member/tipe_member/modal_form",function() {
                $('#modal_form').modal('show');
            });
        });

        //Form edit tipe member
        $(".ganti").click(function(){
            $('#tampil_form').load("<?=site_url()?>member/tipe_member/modal_form/"+$(this).attr('id'),function() {
                $('#modal_form').modal('show');
            });
        });

        $(".hapus").click(function(){
            var cnf = confirm("Apakah anda yakin akan menghapus tipe member ini?");
            if (cnf == true) {
                $.post('<?=site_url()?>member/tipe_member/hapus/' + $(this).attr('id'), function() {
                    alert('Tipe member berhasil dihapus');
                    location.reload();
                });
            }
        });

    } );    
</script>