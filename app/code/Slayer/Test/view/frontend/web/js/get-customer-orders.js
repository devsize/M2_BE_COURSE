/**
 * @api
 */
define([
    'jquery',
    'mage/storage',
    'mage/url',
    'mage/template',
    'text!Slayer_Test/template/customer-orders.html',
    'text!Slayer_Test/template/no-orders.html',
    'domReady!'
], function (
    $,
    storage,
    url,
    mageTemplate,
    customerOrdersTemplate,
    noOrdersTemplate
) {
    'use strict';

    $.widget('slayer.getCustomerOrders', {
        options: {
            useAjax: false,
            serviceUrl: 'rest/all/V1/test/orders/find/:userId',
            userId: 0,
            userName: 'User\'s',
            ordersTemplate: customerOrdersTemplate,
            noOrdersTemplate: noOrdersTemplate,
            container: '#orders-container'
        },

        _create: function () {
            if (!this.options.useAjax) {
                return;
            }

            let self = this;
            console.log('UserId: "' + this.options.userId + '"');
            console.log('AjaxUrl: "' + this.getAjaxUrl(this.options.serviceUrl, this.options.userId) + '"');
            $(this.element).on('click', function (event) {
                event.preventDefault();
                if (self.options.userId > 0) {
                    self.renderCustomerOrders($(this));
                } else {
                    alert('You have not provided with the customer id!');
                }
            });
        },

        renderCustomerOrders: function (element) {
            let self = this;
            let userId = this.options.userId;
            let fullUrl = this.getAjaxUrl(this.options.serviceUrl, userId);
            let container = $(document).find(self.options.container);
            container.trigger('processStart');
            storage.get(
                fullUrl,
                false
            ).done(function (response) {
                console.log(response);
                if (!response.length) {
                    self.renderNoOrdersAnswer(element);
                    return;
                }

                let template = self.options.ordersTemplate;
                let options = {
                    orders: response,
                    hrefMore: element.attr('href'),
                    userName: self.options.userName
                };
                let htmlToInsert = mageTemplate(template, options);
                container.hide();
                container.empty();
                container.html(htmlToInsert);
                container.animate({
                    opacity: 1,
                    width: "show"
                }, 250, function () {
                    container.show();
                });
                self.initClickOnCloseButton(container);
            }).fail(function (response) {
                console.log(response);
            }).always(function () {
                container.trigger('processStop');
            });
        },

        initClickOnCloseButton: function (container) {
            container.find('.close').off('click').on('click', function (event) {
                event.preventDefault();
                container.animate({
                    opacity: 0.25,
                    width: "hide"
                }, 500, function () {
                    container.hide();
                });
            });
        },

        renderNoOrdersAnswer: function () {
            let container = $(document).find(this.options.container);
            let template = this.options.noOrdersTemplate;
            let options = {
                userName: this.options.userName
            };
            let htmlToInsert = mageTemplate(template, options);
            container.hide();
            container.empty();
            container.html(htmlToInsert);
            container.animate({
                opacity: 1,
                width: "show"
            }, 250, function () {
                container.show();
            });
            this.initClickOnCloseButton(container);
        },

        getAjaxUrl: function (serviceUrl, userId) {
            let ajaxUrl = serviceUrl.replace(":userId", userId);
            url.setBaseUrl(BASE_URL);
            return url.build(ajaxUrl)
        }
    });

    return $.slayer.getCustomerOrders;
});