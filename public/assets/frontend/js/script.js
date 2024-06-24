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
const cart_item_product_remove = document.querySelectorAll('.cart_item_product--remove')
if (cart_item_product_remove) {
    cart_item_product_remove.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            let product_id = button.value;

            console.log(product_id);

            $.ajax({
                type: "GET",
                url: '/remove-from-cart/' + product_id,
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
                        text: "Xóa sản phẩm khỏi giỏ hàng thành công",
                        duration: 2000,
                        close: true,
                        gravity: "top", // `top` or `bottom`
                        position: "right", // `left`, `center` or `right`
                        stopOnFocus: true, // Prevents dismissing of toast on hover
                        className: "toastify-custom toastify-success"
                    }).showToast();

                    // reload_cart()
                    window.location.reload();
                },
                error: function () {
                    let existingToast = document.querySelector(".toastify");
                    if (existingToast) {
                        existingToast.remove();
                    }
                    Toastify({
                        text: "Xóa thất bại",
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

const cart_item_product_change = document.querySelectorAll('.cart_item_product--change')

if (cart_item_product_change) {
    cart_item_product_change.forEach(button => {
        button.addEventListener('change', e => {
            e.preventDefault()
            let quantity = button.value;
            let product_id = button.dataset.id;

            $.ajax({
                type: "POST",
                url: '/update-to-cart/' + product_id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    quantity: quantity
                },
                success: function (data) {
                    reload_cart()
                },
                error: function () {
                    console.log('error')
                }
            })
        })
    })
}

const reload_cart = function () {
    $.ajax({
        type: "GET",
        url: '/cart',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Thêm CSRF token vào header
        },
        success: function (data) {
            console.log('success')
            window.location.reload()
        },
        error: function () {
            console.log('error')
        }
    })
}

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
