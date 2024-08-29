<script>
    function confirmDelete(url,id) {
        Swal.fire({
            title: '{{trans("common.Are you sure?")}}',
            text: "{{trans('common.You wont be able to revert this!')}}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '{{trans("common.Yes, delete it!")}}',
            cancelButtonText: '{{trans("common.Cancel")}}',
            customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-outline-danger ms-1'
            },
            buttonsStyling: false
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    method   : 'get',
                    url      : url,
                    dataType : 'json',
                    success : function(data){
                        if(data != "false"){
                            Swal.fire({
                                icon: 'success',
                                title: '{{trans("common.Deleted!")}}',
                                text: '{{trans("common.Your file has been deleted.")}}',
                                customClass: {
                                confirmButton: 'btn btn-success'
                                }
                            });
                            $('#row_'+data).fadeOut();
                            $('#row_'+data).remove();
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: '{{trans("common.NotDeleted!")}}',
                                text: '{{trans("common.Your file has not been deleted.")}}',
                                customClass: {
                                confirmButton: 'btn btn-success'
                                }
                            });
                        }
                    }
                })
            }
        });
    }
</script>