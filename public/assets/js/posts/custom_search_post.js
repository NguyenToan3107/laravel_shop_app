// reset post
document.getElementById('reset_btn_post').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('title_post').value = '';
    document.getElementById('author_post').value = '';
    document.getElementById('status_post').value = '';
    document.getElementById('start_date').value = '';
    document.getElementById('ended_date').value = '';

    if ($.fn.DataTable.isDataTable('#posts-table')) {
        $('#posts-table').DataTable().destroy(); // Nếu có, hủy bảng DataTable hiện tại
    }

    $('#posts-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/posts',
        type: 'GET',
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
});

// search post
document.getElementById('post_search_form').addEventListener('submit', function(event) {
    event.preventDefault();

    let title = document.getElementById('title_post').value;
    let author_name = document.getElementById('author_post').value;
    let status = document.getElementById('status_post').value;
    let started_at = document.getElementById('start_date').value;
    let ended_at = document.getElementById('ended_date').value;

    started_at = datetimeLocalToDateString(started_at)
    ended_at = datetimeLocalToDateString(ended_at)

    if ($.fn.DataTable.isDataTable('#posts-table')) {
        $('#posts-table').DataTable().destroy(); // Nếu có, hủy bảng DataTable hiện tại
    }

    $('#posts-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/search-post',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Thêm CSRF token vào header
            },
            data: {
                title: title,
                author_name: author_name,
                status: status,
                started_at: started_at,
                ended_at: ended_at,
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
});

function datetimeLocalToDateString(datetimeLocal) {
    let date = new Date(datetimeLocal);
    let year = date.getFullYear().toString();
    let month = (date.getMonth() + 1).toString().padStart(2, '0'); // Month is zero-based
    let day = date.getDate().toString().padStart(2, '0');
    let hours = date.getHours().toString().padStart(2, '0');
    let minutes = date.getMinutes().toString().padStart(2, '0');
    let seconds = date.getSeconds().toString().padStart(2, '0');

    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}
