////////////////////////////////////////////////////////////////////////////////////////
// ------------------------------------ POSTS --------------------------------------- //

////////// DELETE
// soft delete
$(document).ready(function () {
    $(document).on('click', '.delete_button_post', function (event) {
        event.preventDefault();
        let slug = $(this).val();
        $('#deleteModal').modal('show')
        $('#confirmDeleteButton_trash').val(slug)

        $('#confirmDeleteButton_trash').on('click', function (event) {
            event.preventDefault();
            let slug = $(this).val();

            if ($.fn.DataTable.isDataTable('#posts-table')) {
                $('#posts-table').DataTable().destroy();
            }

            $('#posts-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `/admin/posts/soft_delete`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        slug: slug,
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = xhr.status + ': ' + xhr.statusText
                        console.error('AJAX Error: ' + errorMessage);

                        $('#deleteModal').modal('hide')
                        let existingToast = document.querySelector(".toastify");
                        if (existingToast) {
                            existingToast.remove();
                        }
                        Toastify({
                            text: "Đã xảy ra lỗi khi xóa bài viết",
                            duration: 2000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            stopOnFocus: true,
                            className: "toastify-custom toastify-error"
                        }).showToast();

                        reset_post_datatable();
                    },
                    success: function () {
                        $('#deleteModal').modal('hide')
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
                            className: "toastify-custom toastify-success"
                        }).showToast();

                        reset_post_datatable();
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
                ],
            });
        })
    })
})

// Hard delete
$(document).ready(function () {
    $(document).on('click', '.trash_button_post', function (event) {
        event.preventDefault();
        let slug = $(this).val();
        $('#trashModal').modal('show')
        $('#confirmDeleteButton_remove').val(slug)

        $('#confirmDeleteButton_remove').on('click', function (event) {
            event.preventDefault();
            let slug = $(this).val();

            if ($.fn.DataTable.isDataTable('#posts-table')) {
                $('#posts-table').DataTable().destroy();
            }

            $('#posts-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `/admin/posts/` + slug,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        slug: slug,
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = xhr.status + ': ' + xhr.statusText
                        console.error('AJAX Error: ' + errorMessage);

                        $('#trashModal').modal('hide')
                        let existingToast = document.querySelector(".toastify");
                        if (existingToast) {
                            existingToast.remove();
                        }
                        Toastify({
                            text: "Đã xảy ra lỗi khi xóa bài viết",
                            duration: 2000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            stopOnFocus: true,
                            className: "toastify-custom toastify-error"
                        }).showToast();

                        reset_post_datatable();
                    },
                    success: function () {
                        $('#trashModal').modal('hide')
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
                            className: "toastify-custom toastify-success"
                        }).showToast();

                        reset_post_datatable();
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

        reset_post_datatable();
    });
}

const reset_post_datatable = function () {
    if ($.fn.DataTable.isDataTable('#posts-table')) {
        $('#posts-table').DataTable().destroy(); // Nếu có, hủy bảng DataTable hiện tại
    }

    $('#posts-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/admin/posts',
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
                url: '/admin/search-post',
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


////////////////////////////////////////////////////////////////////////////////////////
// --------------------------------- ORDERS --------------------------------------- //

////////////// SEARCH

// search post
const order_search_form = document.getElementById('order_search_form')

if(order_search_form) {
    order_search_form.addEventListener('submit', function (event) {
        event.preventDefault();

        let fullname = document.getElementById('full_name_order').value;
        let email = document.getElementById('email_order').value;
        let phone = document.getElementById('phone_order').value;
        let status = document.getElementById('status_order').value;
        let started_at = document.getElementById('start_date').value;
        let ended_at = document.getElementById('ended_date').value;

        started_at = datetimeLocalToDateString(started_at)
        ended_at = datetimeLocalToDateString(ended_at)

        if ($.fn.DataTable.isDataTable('#orders-table')) {
            $('#orders-table').DataTable().destroy(); // Nếu có, hủy bảng DataTable hiện tại
        }

        $('#orders-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/admin/search-order',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Thêm CSRF token vào header
                },
                data: {
                    fullname: fullname,
                    email: email,
                    phone: phone,
                    status: status,
                    started_at: started_at,
                    ended_at: ended_at,
                }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'fullname', name: 'fullname'},
                // {data: 'author_id', name: 'author_id'},
                {data: 'phone', name: 'phone'},
                {data: 'address', name: 'address'},
                {data: 'percent_sale', name: 'percent_sale'},
                {data: 'price', name: 'price'},
                {data: 'status', name: 'status'},
                { data: 'updated_at', name: 'updated_at' },
                {data: 'action', name: 'action'}
            ]
        });
    });
}

// reset post
const reset_btn_order = document.getElementById('reset_btn_order')

if(reset_btn_order) {
    reset_btn_order.addEventListener('click', function (event) {
        event.preventDefault();
        document.getElementById('full_name_order').value = '';
        document.getElementById('email_order').value = '';
        document.getElementById('phone_order').value = '';
        document.getElementById('status_order').value = '';
        document.getElementById('start_date').value = '';
        document.getElementById('ended_date').value = '';

        reset_order_datatable();
    });
}

const reset_order_datatable = function () {
    if ($.fn.DataTable.isDataTable('#orders-table')) {
        $('#orders-table').DataTable().destroy(); // Nếu có, hủy bảng DataTable hiện tại
    }

    $('#orders-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/admin/orders',
        type: 'GET',
        order: [6, 'asc'],
        columns: [
            {data: 'id', name: 'id'},
            {data: 'fullname', name: 'fullname'},
            // {data: 'author_id', name: 'author_id'},
            {data: 'phone', name: 'phone'},
            {data: 'address', name: 'address'},
            {data: 'percent_sale', name: 'percent_sale'},
            {data: 'price', name: 'price'},
            {data: 'status', name: 'status'},
            { data: 'updated_at', name: 'updated_at' },
            {data: 'action', name: 'action'}
        ]
    });
}



///////////////////// DELETE ORDER
// soft delete
$(document).ready(function () {
    $(document).on('click', '.trash_button_order', function (event) {
        event.preventDefault();
        let order_id = $(this).val();
        $('#deleteModal').modal('show')
        $('#confirmDeleteButton_trash').val(order_id)

        $('#confirmDeleteButton_trash').on('click', function (event) {
            event.preventDefault();
            let order_id = $(this).val();

            if ($.fn.DataTable.isDataTable('#orders-table')) {
                $('#orders-table').DataTable().destroy();
            }

            $('#orders-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `/admin/orders/soft_delete`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        order_id: order_id,
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = xhr.status + ': ' + xhr.statusText
                        console.error('AJAX Error: ' + errorMessage);

                        $('#deleteModal').modal('hide')
                        let existingToast = document.querySelector(".toastify");
                        if (existingToast) {
                            existingToast.remove();
                        }
                        Toastify({
                            text: "Đã xảy ra lỗi khi xóa đơn hàng",
                            duration: 2000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            stopOnFocus: true,
                            className: "toastify-custom toastify-error"
                        }).showToast();

                        reset_order_datatable();
                    },
                    success: function () {
                        $('#deleteModal').modal('hide')
                        let existingToast = document.querySelector(".toastify");
                        if (existingToast) {
                            existingToast.remove();
                        }
                        Toastify({
                            text: "Xóa đơn hàng thành công",
                            duration: 2000,
                            close: true,
                            gravity: "top", // `top` or `bottom`
                            position: "right", // `left`, `center` or `right`
                            stopOnFocus: true, // Prevents dismissing of toast on hover
                            className: "toastify-custom toastify-success"
                        }).showToast();

                        reset_order_datatable();
                    }
                },
                order: [6, 'asc'],
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'fullname', name: 'fullname'},
                    // {data: 'author_id', name: 'author_id'},
                    {data: 'phone', name: 'phone'},
                    {data: 'address', name: 'address'},
                    {data: 'percent_sale', name: 'percent_sale'},
                    {data: 'price', name: 'price'},
                    {data: 'status', name: 'status'},
                    { data: 'updated_at', name: 'updated_at' },
                    {data: 'action', name: 'action'}
                ]
            });
            $('#deleteModal').modal('hide')
        })
    })
})

// hard delete
$(document).ready(function () {
    $(document).on('click', '.delete_button_order', function (event) {
        event.preventDefault();
        let order_id = $(this).val();
        $('#trashModal').modal('show')
        $('#confirmDeleteButton_remove').val(order_id)

        $('#confirmDeleteButton_remove').on('click', function (event) {
            event.preventDefault();
            let order_id = $(this).val();

            if ($.fn.DataTable.isDataTable('#orders-table')) {
                $('#orders-table').DataTable().destroy();
            }

            $('#orders-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `/admin/orders/` + order_id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: order_id,
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = xhr.status + ': ' + xhr.statusText
                        console.error('AJAX Error: ' + errorMessage);

                        $('#trashModal').modal('hide')
                        let existingToast = document.querySelector(".toastify");
                        if (existingToast) {
                            existingToast.remove();
                        }
                        Toastify({
                            text: "Đã xảy ra lỗi khi xóa đơn hàng",
                            duration: 2000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            stopOnFocus: true,
                            className: "toastify-custom toastify-error"
                        }).showToast();

                        reset_order_datatable();
                    },
                    success: function () {
                        $('#trashModal').modal('hide')
                        let existingToast = document.querySelector(".toastify");
                        if (existingToast) {
                            existingToast.remove();
                        }
                        Toastify({
                            text: "Xóa đơn hàng thành công",
                            duration: 2000,
                            close: true,
                            gravity: "top", // `top` or `bottom`
                            position: "right", // `left`, `center` or `right`
                            stopOnFocus: true, // Prevents dismissing of toast on hover
                            className: "toastify-custom toastify-success"
                        }).showToast();

                        reset_order_datatable();
                    }
                },
                order: [6, 'asc'],
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'fullname', name: 'fullname'},
                    // {data: 'author_id', name: 'author_id'},
                    {data: 'phone', name: 'phone'},
                    {data: 'address', name: 'address'},
                    {data: 'percent_sale', name: 'percent_sale'},
                    {data: 'price', name: 'price'},
                    {data: 'status', name: 'status'},
                    { data: 'updated_at', name: 'updated_at' },
                    {data: 'action', name: 'action'}
                ]
            });
        })
    })
})













////////////////////////////////////////////////////////////////////////////////////////
// --------------------------------- PRODUCTS --------------------------------------- //

////////// DELETE
// soft delete
$(document).ready(function () {
    $(document).on('click', '.delete_button_product', function (event) {
        event.preventDefault();
        let slug = $(this).val();
        $('#deleteModal').modal('show')
        $('#confirmDeleteButton_trash').val(slug)

        $('#confirmDeleteButton_trash').on('click', function (event) {
            event.preventDefault();
            let slug = $(this).val();

            if ($.fn.DataTable.isDataTable('#products-table')) {
                $('#products-table').DataTable().destroy();
            }

            $('#products-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `/admin/soft_delete`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        slug: slug,
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'image', name: 'image'},
                    {data: 'title', name: 'title'},
                    {data: 'price_old', name: 'price_old'},
                    {data: 'percent_sale', name: 'percent_sale'},
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
        let slug = $(this).val();
        $('#trashModal').modal('show')
        $('#confirmDeleteButton_remove').val(slug)

        $('#confirmDeleteButton_remove').on('click', function (event) {
            event.preventDefault();
            let slug = $(this).val();

            if ($.fn.DataTable.isDataTable('#products-table')) {
                $('#products-table').DataTable().destroy();
            }

            $('#products-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `/admin/products/` + slug,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        slug: slug,
                    },
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'image', name: 'image'},
                    {data: 'title', name: 'title'},
                    {data: 'price_old', name: 'price_old'},
                    {data: 'percent_sale', name: 'percent_sale'},
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
            ajax: '/admin/products',
            type: 'GET',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'image', name: 'image'},
                {data: 'title', name: 'title'},
                {data: 'price_old', name: 'description'},
                {data: 'percent_sale', name: 'percent_sale'},
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
                url: '/admin/search-product',
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
            scrollX: true,
            columns: [
                {data: 'id', name: 'id'},
                {data: 'image', name: 'image'},
                {data: 'title', name: 'title'},
                {data: 'price_old', name: 'description'},
                {data: 'percent_sale', name: 'percent_sale'},
                {data: 'price', name: 'price'},
                {data: 'status', name: 'status'},
                // { data: 'created_at', name: 'created_at' },
                // { data: 'updated_at', name: 'updated_at' },
                {data: 'action', name: 'action'}
            ]
        });
    });
}



///////////// PRODUCT ATRRIBUTE VALUE

$(document).ready(function () {
    $(document).ajaxSend(function () {
        $("#overlay").fadeIn(100);
    })
    $(document).on('click', '.delete_product_attribute_value', function (e) {
        e.preventDefault();
        let product_attribute_value_id = $(this).data('id');
        let product_attribute_id = $(this).data('attr');

        $.ajax({
            url: '/admin/product_attributes/' + product_attribute_id + '/product_attribute_value/' + product_attribute_value_id,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
                    $.ajax({
                    type: 'GET',
                    url: '/admin/product_attributes/' + product_attribute_id + '/edit',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        var list_attribute_value = $(data).find('#product_attribute_value_list').html();
                        $('#product_attribute_value_list').html(list_attribute_value);
                    }
                })
            }
        }).done(function () {
            setTimeout(function () {
                $('#overlay').fadeOut(100)
            }, 200)
        }).fail(function (xhr, status, error) {
            setTimeout(function () {
                $('#overlay').fadeOut(100)
            }, 200);
            Toastify({
                text: "Xóa thất bại!",
                duration: 2000,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                className: "toastify-custom toastify-error"
            }).showToast();
        })
    })
})





////////////////////////////////////////////////////////////////////////////////////////
// ------------------------------------ USERS --------------------------------------- //


// search product
const user_search_form = document.getElementById('user_search_form')

if(user_search_form) {
    user_search_form.addEventListener('submit', function (event) {
        event.preventDefault();

        let name =  document.getElementById('name_user').value;
        let email = document.getElementById('email_user').value;
        let phone = document.getElementById('phone_user').value;
        let address = document.getElementById('address_user').value;
        let age = document.getElementById('age_user').value;
        let status = document.getElementById('status_user').value;
        let started_at = document.getElementById('start_date').value;
        let ended_at = document.getElementById('ended_date').value;

        started_at = datetimeLocalToDateString(started_at)
        ended_at = datetimeLocalToDateString(ended_at)
        if ($.fn.DataTable.isDataTable('#users-table')) {
            $('#users-table').DataTable().destroy(); // Nếu có, hủy bảng DataTable hiện tại
        }

        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/admin/search-user',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Thêm CSRF token vào header
                },
                data: {
                    name: name,
                    email: email,
                    phone: phone,
                    address: address,
                    age: age,
                    status: status,
                    started_at: started_at,
                    ended_at: ended_at,
                }
            },
            scrollX: true,
            columns: [
                {data: 'id', name: 'id'},
                {data: 'image_path', name: 'image_path'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'phoneNumber', name: 'phoneNumber'},
                {data: 'address', name: 'address'},
                {data: 'roles', name: 'roles'},
                {data: 'age', name: 'age'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action'}
            ]
        });
    });
}


// reset user
const reset_btn_user = document.getElementById('reset_btn_user')

if(reset_btn_user) {
    reset_btn_user.addEventListener('click', function (event) {
        event.preventDefault();
        document.getElementById('name_user').value = '';
        document.getElementById('email_user').value = '';
        document.getElementById('phone_user').value = '';
        document.getElementById('address_user').value = '';
        document.getElementById('age_user').value = '';
        document.getElementById('status_user').value = '';
        document.getElementById('start_date').value = '';
        document.getElementById('ended_date').value = '';

        if ($.fn.DataTable.isDataTable('#users-table')) {
            $('#users-table').DataTable().destroy(); // Nếu có, hủy bảng DataTable hiện tại
        }

        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/admin/users',
            type: 'GET',
            scrollX: true,
            columns: [
                {data: 'id', name: 'id'},
                {data: 'image_path', name: 'image_path'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'phoneNumber', name: 'phoneNumber'},
                {data: 'address', name: 'address'},
                {data: 'roles', name: 'roles'},
                {data: 'age', name: 'age'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action'}
            ]
        });
    })
}


////////// DELETE
// soft delete
$(document).ready(function () {
    $(document).on('click', '.delete_button_user', function (event) {
        event.preventDefault();
        let user_id = $(this).val();
        $('#deleteModal').modal('show')
        $('#confirmDeleteButton_trash').val(user_id)

        $('#confirmDeleteButton_trash').on('click', function (event) {
            event.preventDefault();
            let user_id = $(this).val();

            if ($.fn.DataTable.isDataTable('#users-table')) {
                $('#users-table').DataTable().destroy();
            }

            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `/admin/users/soft_delete`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        user_id: user_id,
                    }
                },
                scrollX: true,
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'image_path', name: 'image_path'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'phoneNumber', name: 'phoneNumber'},
                    {data: 'address', name: 'address'},
                    {data: 'roles', name: 'roles'},
                    {data: 'age', name: 'age'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action'}
                ]
            });

            // // Hiển thị modal thông báo thành công sau khi modal xóa được ẩn
            // $('#deleteModal').on('hidden.bs.modal', function () {
            //     $('#successModal').modal('show');
            // });

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
                className: "toastify-custom toastify-error"
            }).showToast();
        })
    })
})


// hard delete
$(document).ready(function () {
    $(document).on('click', '.trash_button_user', function (event) {
        event.preventDefault();
        let user_id = $(this).val();
        $('#trashModal').modal('show')
        $('#confirmDeleteButton_remove').val(user_id)

        $('#confirmDeleteButton_remove').on('click', function (event) {
            event.preventDefault();
            let user_id = $(this).val();

            if ($.fn.DataTable.isDataTable('#users-table')) {
                $('#users-table').DataTable().destroy();
            }

            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `/admin/users/` + user_id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: user_id,
                    },
                },
                scrollX: true,
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'image_path', name: 'image_path'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'phoneNumber', name: 'phoneNumber'},
                    {data: 'address', name: 'address'},
                    {data: 'roles', name: 'roles'},
                    {data: 'age', name: 'age'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action'}
                ]
            });
            $('#trashModal').modal('hide')

            // $('#trashModal').on('hidden.bs.modal', function () {
            //     $('#successModal').modal('show');
            // });

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
                className: "toastify-custom toastify-error"
            }).showToast();
        })
    })
})







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

