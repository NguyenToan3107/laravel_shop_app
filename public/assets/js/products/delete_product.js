// soft delete
$(document).ready(function () {
    $(document).on('click', '.delete_button_product', function (event) {
        event.preventDefault();
        var product_id = $(this).val();
        $('#deleteModal').modal('show')
        $('#confirmDeleteButton_trash').val(product_id)

        $('#confirmDeleteButton_trash').on('click', function (event) {
            event.preventDefault();
            var product_id = $(this).val();

            if ($.fn.DataTable.isDataTable('#products-table')) {
                $('#products-table').DataTable().destroy();
            }

            $('#products-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `/soft_delete`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        product_id: product_id,
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'image', name: 'image'},
                    {data: 'title', name: 'title'},
                    {data: 'description', name: 'description'},
                    {data: 'price', name: 'price'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action'}
                ]
            });
            $('#deleteModal').modal('hide')

            // Hiển thị modal thông báo thành công sau khi modal xóa được ẩn
            $('#deleteModal').on('hidden.bs.modal', function () {
                $('#successModal').modal('show');
            });
        })
    })


})

