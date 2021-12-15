<script type="text/javascript">

        $(document).on('change','.basic_fields_status', function() { 
            //alert('sdf');
                id = $(this).data('field');
                var field_for  = $(this).data('field_for');
                //alert(field_for);
                if ($(this).is(':checked')) {
                    status = 1;
                } else {
                    status = 0;
                }
                var url = "<?=base_url()?>form/form/change_basic_enquiry_field_status"
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        id: id,
                        status: status,
                        comp_id: "<?=$comp_id?>",
                        field_for:field_for
                    },
                    success: function(data) {
                        if (data == 1) {
                            Swal.fire(
                                'Status Changed Successfully!',
                                '',
                                'success'
                            )
                        }
                    }
                });
            });


            $(document).on('change','.extra_fields_status', function() {
                id = $(this).data('field');
                if ($(this).is(':checked')) {
                    status = 1;
                } else {
                    status = 0;
                }
                var url = "<?=base_url()?>form/form/change_extra_enquiry_field_status"
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        id: id,
                        status: status,
                        comp_id: "<?=$comp_id?>"
                    },
                    //beforeSend:function(){ alert(status+" "+id);},
                    success: function(data) {
                        if (data == 1) {
                            Swal.fire(
                                'Status Changed Successfully!',
                                '',
                                'success'
                            )
                        }
                    }
                });
            });



function save_form_row(id,field_for, basic = true) {
    var comp_id = "<?=$comp_id?>";
    var process_ids = $("select[name='product_id[" + id + "][]']").val();
//alert(process_ids);
    var url = "<?=base_url()?>form/form/save_form_row";
    $.ajax({
        type: "POST",
        url: url,
        data: {
            id: id,
            comp_id: "<?=$comp_id?>",
            process_ids: process_ids,
            basic: basic,
            field_for:field_for
        },
        success: function(data) {
            if (data) {
                Swal.fire(
                    'Saved Successfully!',
                    '',
                    'success'
                )
            }
        }
    });

}


</script>