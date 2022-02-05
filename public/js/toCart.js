$(document).ready(function () {

    $('body').on('click', '.toCart', function (e) {

        const cartItems = JSON.parse(sessionStorage.getItem('cartItems')) || [];
        console.log(cartItems)
        cartItems.push(e.target.id);
        sessionStorage.setItem('cartItems', JSON.stringify(cartItems));
        successToast('Uspesno dodato u korpu!');
    });

    const successToast = (message) => {

        $('.success-toast .toast-body').html(message);
        $('.success-toast').toast('show');
    };
});
