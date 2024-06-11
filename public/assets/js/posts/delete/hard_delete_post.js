
// hard delete
$(document).ready(function () {
    $(document).on('click', '.trash_button_post', function (event) {
        event.preventDefault();
        var post_id = $(this).val();
        $('#trashModal').modal('show')
        $('#confirmDeleteButton_remove').val(post_id)

        $('#confirmDeleteButton_remove').on('click', function (event) {
            event.preventDefault();
            var post_id = $(this).val();

            if ($.fn.DataTable.isDataTable('#posts-table')) {
                $('#posts-table').DataTable().destroy();
            }

            $('#posts-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `/posts/` + post_id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: post_id,
                    },
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
            $('#trashModal').modal('hide')

            $('#trashModal').on('hidden.bs.modal', function () {
                $('#successModal').modal('show');
            });
        })
    })


})

