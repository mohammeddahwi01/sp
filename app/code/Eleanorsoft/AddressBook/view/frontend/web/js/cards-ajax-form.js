define([
    'jquery',
    'Eleanorsoft_Lib/js/ajax-form'
], function ($, EleanorsoftLibAjaxForm) {

    return EleanorsoftLibAjaxForm.extend({
        initialize: function (config) {
            this._super();
            this.isFormShown = false;
            this.isFormShownAddMode = false;
            this.cardData = config.cardDataJson;
            this.ui = {
                formKey: $('[name=form_key]'),
                form: $('#form-validate'),
                waiting: $('#credit-cart-waiting'),
                method:$("input[name='method']"),
                isComponentActive: $('#credit-cart-is-js-component-active'),
                id: $('#cardiId'),
                firstname: $('#creditcart #firstname'),
                lastname: $('#creditcart #lastname'),
                company: $('#company'),
                telephone: $('#telephone'),
                city: $('#city'),
                street: $('#street'),
                postcode: $('#zip'),
                region: $('#region-id'),
                country: $('#country')
            };
        },

        removeCart: function () {
            if (confirm('Are you sure?')) {
                var id = $('#credit-cart-select option:selected').val();
                this.ui.waiting.show();
                console.log({
                    id: id,
                    form_key: this.ui.formKey.val(),
                    method:this.ui.method.val()
                });
                $.post('/customer/paymentinfo/delete', {
                    id: id,
                    form_key: this.ui.formKey.val(),
                    method:this.ui.method.val()
                }, function () {
                    alert('Credit Card has been deleted successfully.');
                    location.reload();
                });
            }
        },


        hideAllAddressForm: function () {
            $('[id*=waiting]').hide();
            $('[id*=form-validate]').hide();

            if (!this.ui.isComponentActive.val()) {
                this.isFormShown = false;
                this.isFormShownAddMode = false;
            }

            $('[id*=is-js-component-active]').val('');
            this.ui.isComponentActive.val('1');
        },

        editCart: function () {
            this.hideAllAddressForm();

            this.isFormShownAddMode = false;

            document.getElementById('credit-cart-select')
                .dispatchEvent(new Event('change'));

            if (this.isFormShown) {
                this.isFormShown = false;

                this.ui.form.hide();
            } else {
                this.isFormShown = true;

                this.ui.form.show();
            }
        },

        addCart: function () {
            this.hideAllAddressForm();

            this.isFormShown = false;

            this.pupulateCartUi({
                id: '',
                city: '',
                company: '',
                postcode: '',
                lastname: '',
                firstname: '',
                telephone: '',
                country_id: 'US',
                region_id: 0,
                street: ''
            });

            if (this.isFormShownAddMode) {
                this.isFormShownAddMode = false;

                this.ui.form.hide();
            } else {
                this.isFormShownAddMode = true;

                this.ui.form.show();
            }
        },
        cardChanged: function (selectElement) {
            if (
                typeof this.cardData === 'undefined'
                || this.cardData.length === 0
            ) {
                return false;
            }

            this.pupulateCartUi(
                this.cardData.find(function (card) {
                    return card.hash == selectElement.value;
                })
            );
        },

        pupulateCartUi: function (card) {
            this.ui.id.val(card.hash);
            this.ui.firstname.val(card.firstname);
            this.ui.lastname.val(card.lastname);
            this.ui.company.val(card.company);
            this.ui.telephone.val(card.telephone);
            this.ui.city.val(card.city);
            this.ui.street.val(card.street);
            this.ui.postcode.val(card.postcode);
            this.ui.country.val(card.country_id);
            this.ui.region.val(card.region_id ? card.region_id : '');
        }
    });
});