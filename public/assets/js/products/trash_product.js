// call all product soft delete
document.getElementById('trash_link').addEventListener('click', function(event) {
    event.preventDefault();

    if ($.fn.DataTable.isDataTable('#products-table')) {
        $('#products-table').DataTable().destroy(); // Nếu có, hủy bảng DataTable hiện tại
    }

    $('#products-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/products/trash',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Thêm CSRF token vào header
            },
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'image', name: 'image' },
            { data: 'title', name: 'title' },
            { data: 'description', name: 'description' },
            { data: 'price', name: 'price' },
            { data: 'status', name: 'status' },
            // { data: 'created_at', name: 'created_at' },
            // { data: 'updated_at', name: 'updated_at' },
            { data: 'action', name: 'action' }
        ]
    });
});

// hard delete
$(document).ready(function () {
    $(document).on('click', '.trash_button_product', function (event) {
        event.preventDefault();
        var product_id = $(this).val();
        $('#trashModal').modal('show')
        $('#confirmDeleteButton_remove').val(product_id)

        $('#confirmDeleteButton_remove').on('click', function (event) {
            event.preventDefault();
            var product_id = $(this).val();

            if ($.fn.DataTable.isDataTable('#products-table')) {
                $('#products-table').DataTable().destroy();
            }

            $('#products-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `/products/` + product_id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: product_id,
                    },
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
            $('#trashModal').modal('hide')

            $('#trashModal').on('hidden.bs.modal', function () {
                $('#successModal').modal('show');
            });
        })
    })


})

