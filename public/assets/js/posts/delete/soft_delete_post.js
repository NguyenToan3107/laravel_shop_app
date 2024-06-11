// soft delete
$(document).ready(function () {
    $(document).on('click', '.delete_button_post', function (event) {
        event.preventDefault();
        let post_id = $(this).val();
        $('#deleteModal').modal('show')
        $('#confirmDeleteButton_trash').val(post_id)

        $('#confirmDeleteButton_trash').on('click', function (event) {
            event.preventDefault();
            let post_id = $(this).val();

            if ($.fn.DataTable.isDataTable('#posts-table')) {
                $('#posts-table').DataTable().destroy();
            }

            $('#posts-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `/posts/soft_delete`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        post_id: post_id,
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'image', name: 'image' },
                    { data: 'title', name: 'title' },
                    { data: 'description', name: 'description' },
                    { data: 'author_id', name: 'author_id' },
                    { data: 'status', name: 'status' },
                    // { data: 'created_at', name: 'created_at' },
                    // { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action' }
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

