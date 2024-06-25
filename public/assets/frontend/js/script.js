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
                });
            },
            error: function () {
                console.log("Error removing product from cart");
            }
        });
    });
});

$(document).ready(function () {
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
               })
           },
           error: function () {
               console.log('error')
           }
       })

   })
});

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
