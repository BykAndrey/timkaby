'use strict';

module.exports = {
    name: 'good',
    props: ['item'],
    methods: {
        getUrl: function getUrl(caturl, url) {
            var url = '/catalog/' + caturl + '/' + url;
            return url;
        },
        toCatd: function toCatd(caturl, url) {
            window.location = this.getUrl(caturl, url);
        },
        addToCart: function addToCart(id) {
            $.ajax({
                url: '/cart/cart_add',
                method: 'get',
                async: false,
                data: {
                    'id': id
                },
                success: function success(data) {
                    if (data == 1) {}
                }
            });
            header_cart.refresh();
        }
    }
};