////////////////////////////////////////////////////////////////////////////////////////
// ------------------------------------ POSTS --------------------------------------- //

////////// DELETE
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
                    {data: 'id', name: 'id'},
                    {data: 'image', name: 'image'},
                    {data: 'title', name: 'title'},
                    {data: 'description', name: 'description'},
                    {data: 'author_id', name: 'author_id'},
                    {data: 'status', name: 'status'},
                    // { data: 'created_at', name: 'created_at' },
                    // { data: 'updated_at', name: 'updated_at' },
                    {data: 'action', name: 'action'}
                ]
            });
            $('#deleteModal').modal('hide')
            // kiểm tra nếu toast trước đó vẫn còn
            let existingToast = document.querySelector(".toastify");
            if (existingToast) {
                existingToast.remove();
            }
            Toastify({
                text: "Xóa thành công",
                duration: 2000,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                className: "toastify-custom"
            }).showToast();
        })
    })
})

// Hard delete
$(document).ready(function () {
    $(document).on('click', '.trash_button_post', function (event) {
        event.preventDefault();
        let post_id = $(this).val();
        $('#trashModal').modal('show')
        $('#confirmDeleteButton_remove').val(post_id)

        $('#confirmDeleteButton_remove').on('click', function (event) {
            event.preventDefault();
            let post_id = $(this).val();

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
                    {data: 'id', name: 'id'},
                    {data: 'image', name: 'image'},
                    {data: 'title', name: 'title'},
                    {data: 'description', name: 'description'},
                    {data: 'author_id', name: 'author_id'},
                    {data: 'status', name: 'status'},
                    // { data: 'created_at', name: 'created_at' },
                    // { data: 'updated_at', name: 'updated_at' },
                    {data: 'action', name: 'action'}
                ]
            });
            $('#trashModal').modal('hide')

            let existingToast = document.querySelector(".toastify");
            if (existingToast) {
                existingToast.remove();
            }
            // kiểm tra nếu toast trước đó vẫn còn
            Toastify({
                text: "Xóa thành công",
                duration: 2000,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                className: "toastify-custom"
            }).showToast();
        })
    })
})


////////////// SEARCH
// reset post
const reset_btn_post = document.getElementById('reset_btn_post')

if(reset_btn_post) {
    reset_btn_post.addEventListener('click', function (event) {
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
                {data: 'id', name: 'id'},
                {data: 'image', name: 'image'},
                {data: 'title', name: 'title'},
                {data: 'description', name: 'description'},
                {data: 'author_id', name: 'author_id'},
                {data: 'status', name: 'status'},
                // { data: 'created_at', name: 'created_at' },
                // { data: 'updated_at', name: 'updated_at' },
                {data: 'action', name: 'action'}
            ]
        });
    });
}

// search post
const post_search_form = document.getElementById('post_search_form')

if(post_search_form) {
    post_search_form.addEventListener('submit', function (event) {
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
                {data: 'id', name: 'id'},
                {data: 'image', name: 'image'},
                {data: 'title', name: 'title'},
                {data: 'description', name: 'description'},
                {data: 'author_id', name: 'author_id'},
                {data: 'status', name: 'status'},
                // { data: 'created_at', name: 'created_at' },
                // { data: 'updated_at', name: 'updated_at' },
                {data: 'action', name: 'action'}
            ]
        });
    });
}


// create post
const post_create_form = document.getElementById('formMain_create')

if(post_create_form) {
    post_create_form.addEventListener('submit', (event) => {
        event.preventDefault();

        let description_text = tinymce.get('description').getContent({ format: 'text' });
        let content_text = tinymce.get('content').getContent({ format: 'text' });

        let author_id = document.getElementById('author_id').value ?? 1;
        let title = document.getElementById('title').value ?? '';
        let description = document.getElementById('description').innerText = description_text;
        let content = document.getElementById('content').innerText = content_text;
        let filepath = document.getElementById('thumbnail').value;

        console.log(description + ' ' + content);

        $.ajax({
            type: "POST",
            url: '/posts',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Thêm CSRF token vào header
            },
            data: {
                author_id,
                title,
                description,
                content,
                filepath
            }, // serializes the form's elements.
            success: function(data)
            {
                let existingToast = document.querySelector(".toastify");
                if (existingToast) {
                    existingToast.remove();
                }
                // kiểm tra nếu toast trước đó vẫn còn
                Toastify({
                    text: "Tạo mới thành công",
                    duration: 2000,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    className: "toastify-custom toastify-success"
                }).showToast();
            },
            error: function () {
                let existingToast = document.querySelector(".toastify");
                if (existingToast) {
                    existingToast.remove();
                }
                Toastify({
                    text: "Cập nhật thất bại",
                    duration: 2000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    stopOnFocus: true,
                    className: "toastify-custom toastify-error"
                }).showToast();
            }
        })
    })
}


// update post

const post_update_form = document.getElementById('formMain_update')

if(post_update_form) {
    post_update_form.addEventListener('submit', (event) => {
        event.preventDefault();

        let description_text = tinymce.get('description').getContent({ format: 'text' });
        let content_text = tinymce.get('content').getContent({ format: 'text' });

        let post_id = document.getElementById('post_update_id').value
        let author_id = document.getElementById('author_id').value ?? 1;
        let title = document.getElementById('title').value ?? '';
        let description = document.getElementById('description').innerText = description_text;
        let content = document.getElementById('content').innerText = content_text;
        let filepath = document.getElementById('thumbnail').value;
        let status = document.getElementById('status').value;

        console.log(description + ' ' + content + ' ' + post_id);

        $.ajax({
            type: "POST",
            url: `/posts/` + post_id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Thêm CSRF token vào header
            },
            data: {
                _method: 'PUT',
                id: post_id,
                author_id,
                title,
                description,
                content,
                filepath,
                status
            }, // serializes the form's elements.
            success: function(data)
            {
                let existingToast = document.querySelector(".toastify");
                if (existingToast) {
                    existingToast.remove();
                }
                // kiểm tra nếu toast trước đó vẫn còn
                Toastify({
                    text: "Cập nhật thành công",
                    duration: 2000,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    className: "toastify-custom toastify-success"
                }).showToast();
            },
            error: function () {
                let existingToast = document.querySelector(".toastify");
                if (existingToast) {
                    existingToast.remove();
                }
                Toastify({
                    text: "Cập nhật thất bại",
                    duration: 2000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    stopOnFocus: true,
                    className: "toastify-custom toastify-error"
                }).showToast();
            }
        })
    })
}

////////////////////////////////////////////////////////////////////////////////////////
// --------------------------------- PRODUCTS --------------------------------------- //

////////// DELETE
// soft delete
$(document).ready(function () {
    $(document).on('click', '.delete_button_product', function (event) {
        event.preventDefault();
        let product_id = $(this).val();
        $('#deleteModal').modal('show')
        $('#confirmDeleteButton_trash').val(product_id)

        $('#confirmDeleteButton_trash').on('click', function (event) {
            event.preventDefault();
            let product_id = $(this).val();

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

// hard delete
$(document).ready(function () {
    $(document).on('click', '.trash_button_product', function (event) {
        event.preventDefault();
        let product_id = $(this).val();
        $('#trashModal').modal('show')
        $('#confirmDeleteButton_remove').val(product_id)

        $('#confirmDeleteButton_remove').on('click', function (event) {
            event.preventDefault();
            let product_id = $(this).val();

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


////////////// SEARCH

// reset product
const reset_btn_product = document.getElementById('reset_btn')

if(reset_btn_product) {
    reset_btn_product.addEventListener('click', function (event) {
        event.preventDefault();
        document.getElementById('title_product').value = '';
        document.getElementById('price_product').value = '';
        document.getElementById('status_product').value = '';
        document.getElementById('start_date').value = '';
        document.getElementById('ended_date').value = '';

        if ($.fn.DataTable.isDataTable('#products-table')) {
            $('#products-table').DataTable().destroy(); // Nếu có, hủy bảng DataTable hiện tại
        }

        $('#products-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/products',
            type: 'GET',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'image', name: 'image'},
                {data: 'title', name: 'title'},
                {data: 'description', name: 'description'},
                {data: 'price', name: 'price'},
                {data: 'status', name: 'status'},
                // { data: 'created_at', name: 'created_at' },
                // { data: 'updated_at', name: 'updated_at' },
                {data: 'action', name: 'action'}
            ]
        });
    })
}


// search product
const product_search_form = document.getElementById('product_search_form')

if(product_search_form) {
    product_search_form.addEventListener('submit', function (event) {
        event.preventDefault();

        let title = document.getElementById('title_product').value;
        let price = document.getElementById('price_product').value;
        let status = document.getElementById('status_product').value;
        let started_at = document.getElementById('start_date').value;
        let ended_at = document.getElementById('ended_date').value;

        started_at = datetimeLocalToDateString(started_at)
        ended_at = datetimeLocalToDateString(ended_at)
        if ($.fn.DataTable.isDataTable('#products-table')) {
            $('#products-table').DataTable().destroy(); // Nếu có, hủy bảng DataTable hiện tại
        }

        $('#products-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/search-product',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Thêm CSRF token vào header
                },
                data: {
                    title: title,
                    price: price,
                    status: status,
                    started_at: started_at,
                    ended_at: ended_at,
                }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'image', name: 'image'},
                {data: 'title', name: 'title'},
                {data: 'description', name: 'description'},
                {data: 'price', name: 'price'},
                {data: 'status', name: 'status'},
                // { data: 'created_at', name: 'created_at' },
                // { data: 'updated_at', name: 'updated_at' },
                {data: 'action', name: 'action'}
            ]
        });
    });
}

//////////////////////////////////// FUNCTION UTILS ////////////////////////////////////

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


////////////////// DISPLAY IMAGE /////////////////////
const fileInput = document.getElementById('image');
if(fileInput) {
    fileInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const imageURL = URL.createObjectURL(file);
            const imageDisplay = document.getElementById('imageDisplay');
            imageDisplay.src = imageURL;
        }
    });
}
