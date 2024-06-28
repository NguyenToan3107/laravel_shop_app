////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// ADD TO CART
const addToCartButtons = document.querySelectorAll(".product_cart--button");

if (addToCartButtons) {
    addToCartButtons.forEach(button => {
        button.addEventListener("click", (e) => {
            e.preventDefault();

            let product_id = button.value;
            console.log(product_id);

            $.ajax({
                type: "GET",
                url: '/add-to-cart/' + product_id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Thêm CSRF token vào header
                },
                success: function (data) {
                    let existingToast = document.querySelector(".toastify");
                    if (existingToast) {
                        existingToast.remove();
                    }
                    // kiểm tra nếu toast trước đó vẫn còn
                    Toastify({
                        text: "Thêm vào giỏ hàng thành công thành công",
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
                        text: "Thêm thất bại",
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
    })
}


//////////////////////////////// REMOVE FROM CART
$(document).ready(function () {
    $(document).ajaxSend(function () {
        $("#overlay").fadeIn(300);
    })
    // Sử dụng .on() để gắn sự kiện cho các phần tử có lớp .cart_item_product--remove
    $(document).on('click', '.cart_item_product--remove', function (e) {
        e.preventDefault();
        let product_id = $(this).val();

        $.ajax({
            type: "GET",
            url: '/remove-from-cart/' + product_id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                console.log('Product removed successfully');
                // Sau khi xóa thành công, cập nhật lại nội dung giỏ hàng
                $.ajax({
                    type: "GET",
                    url: '/cart',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        // Thay thế nội dung #cart-content bằng HTML mới từ endpoint /cart
                        $('#cart').load(location.href + ' #cart');
                    },
                    error: function () {
                        console.log("Error loading cart content");
                    }
                }).done(function () {
                    setTimeout(function () {
                        $('#overlay').fadeOut(300)
                    }, 500)
                });
            },
            error: function () {
                console.log("Error removing product from cart");
            }
        });
    });
});

///////////////////////////////// UPDATE CART ITEM
$(document).ready(function () {
    $(document).ajaxSend(function () {
        $("#overlay").fadeIn(300);
    });
    $(document).on('change', '.cart_item_product--change', function (event) {
        event.preventDefault();
        let quantity = $(this).val();
        let product_id = $(this).data('id')

        $.ajax({
            type: 'POST',
            url: '/update-to-cart/' + product_id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                quantity: quantity
            },
            success: function (data) {
                $.ajax({
                    type: 'GET',
                    url: '/cart',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        $('#cart').load(location.href + ' #cart');
                    }
                }).done(function () {
                    setTimeout(function () {
                        $("#overlay").fadeOut(300);
                    }, 500)
                })
            },
            error: function () {
                console.log('error')
            }
        })
    })
});


////////////////////////////// PRUDUCT DETAIL ////////////////////


//////////////////////////////// ACTICE when click button choose color, capacity
document.querySelectorAll('.product-detail--capacity p').forEach(p => {
    p.addEventListener('click', () => {
        document.querySelectorAll('.product-detail--capacity p').forEach(p => {
            p.classList.remove('active');
        });
        p.classList.add('active');
    });
});

document.querySelectorAll('.product-detail--color p').forEach(p => {
    p.addEventListener('click', () => {
        document.querySelectorAll('.product-detail--color p').forEach(p => {
            p.classList.remove('active');
        });
        p.classList.add('active');
    });
});

$(document).ready(function () {
    $(document).ajaxSend(function () {
        $("#overlay").fadeIn(100);
    })
    $(document).on('click', '.product-detail--capacity p', function (event) {
        event.preventDefault();
        let capacity = $(this).data('capacity')
        let product_id = $(this).data('id')
        let color = $('.product-detail--color p.active').data('color');

        console.log(capacity + ' ' + product_id + ' ' + color);
        $.ajax({
            type: 'GET',
            url: '/product_detail/' + product_id,
            data: {
                capacity: capacity,
                color: color
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                // $('#product_star--price').load(location.href + ' #product_star--price')
                var newContent = $(data).find('#product_star--price').html();
                $('#product_star--price').html(newContent);
            },
            error: function(xhr, status, error) {
                setTimeout(function () {
                    $('#overlay').fadeOut(100)
                }, 200);
                // Toastify({
                //     text: "Màu này không còn!",
                //     duration: 2000,
                //     close: true,
                //     gravity: "top",
                //     position: "right",
                //     stopOnFocus: true,
                //     className: "toastify-custom toastify-error"
                // }).showToast();
                console.log(error)
            }
        }).done(function () {
            setTimeout(function () {
                $('#overlay').fadeOut(100)
            }, 200)
        })
    })
})

$(document).ready(function () {
    $(document).ajaxSend(function () {
        $("#overlay").fadeIn(100);
    })
    $(document).on('click', '.product-detail--color p', function (event) {
        event.preventDefault();
        let color = $(this).data('color')
        let product_id = $(this).data('id')
        let capacity = $('.product-detail--capacity p.active').data('capacity');

        $.ajax({
            type: 'GET',
            url: '/product_detail/' + product_id,
            data: {
                capacity: capacity,
                color: color
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                // $('#product_star--price').load(location.href + ' #product_star--price')
                var price = $(data).find('#product_star--price').html();
                $('#product_star--price').html(price);

                // var color = $(data).find('.product-detail--color').html();
                // $('.product-detail--color').html(color);
            },
            error: function(xhr, status, error) {

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
                text: "Màu này không còn!",
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

//////////////////////////////// RESPONSIVE //////////////////////

document.querySelector('.menu-toggle').addEventListener('click', function () {
    const nav = document.querySelector('.header_nav--nav');
    nav.classList.add('open');
    console.log(nav.classList.contains('open'));
});

document.addEventListener('click', function (event) {
    const nav = document.querySelector('.header_nav--nav');
    const menuBtn = document.querySelector('.menu-toggle');
    const isClickInsideMenu = nav.contains(event.target);
    const isClickInsideButton = menuBtn.contains(event.target);

    if (!isClickInsideMenu && !isClickInsideButton) {
        nav.classList.remove('open');
    }
});
