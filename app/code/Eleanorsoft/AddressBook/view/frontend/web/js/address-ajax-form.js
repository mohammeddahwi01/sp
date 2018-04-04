define([
    'jquery',
    'Eleanorsoft_Lib/js/ajax-form'
], function ($, EleanorsoftLibAjaxForm) {

    return EleanorsoftLibAjaxForm.extend({
        initialize: function (config) {
            this._super();
            this.isFormShown = false;
            this.isFormShownAddMode = false;
            this.addressType = config.addressType;
            this.addressPrefix = config.addressPrefix;
            this.addressesData = config.addressesDataJson;
            this.ui = {
                formKey: $('[name=form_key]'),
                form: $('#' + this.addressPrefix + 'form-validate'),
                waiting: $('#' + this.addressPrefix + 'waiting'),
                id: $('#' + this.addressPrefix + 'id'),
                defaultAddress: $('#default_' + this.addressType),
                city: $('#' + this.addressPrefix + 'city'),
                company: $('#' + this.addressPrefix + 'company'),
                lastname: $('#' + this.addressPrefix + 'lastname'),
                firstname: $('#' + this.addressPrefix + 'firstname'),
                telephone: $('#' + this.addressPrefix + 'telephone'),
                postcode: $('#' + this.addressPrefix + 'zip'),
                region: $('#' + this.addressPrefix + 'region'),
                country: $('#' + this.addressPrefix + 'country'),
                isComponentActive: $('#' + this.addressPrefix + 'is-js-component-active')
            };
        },

        removeAddress: function () {
            if (confirm('Are you sure?')) {
                this.ui.waiting.show();

                $.post('/customer/address/delete', {
                    id: this.ui.id.val(),
                    form_key: this.ui.formKey.val()
                }, function () {
                    alert('Address has been deleted successfully.');
                    location.reload();
                });
            }
        },

        setAsDefaultAddress: function () {
            if (confirm('Are you sure?')) {
                this.ui.waiting.show();
                this.ui.defaultAddress.val(1);
                this.ui.form.submit();
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

        editAddress: function () {
            this.hideAllAddressForm();

            this.isFormShownAddMode = false;

            document.getElementById(this.addressPrefix + 'addresses')
                .dispatchEvent(new Event('change'));

            if (this.isFormShown) {
                this.isFormShown = false;

                this.ui.form.hide();
            } else {
                this.isFormShown = true;

                this.ui.form.show();
            }
        },

        addAddress: function () {
            this.hideAllAddressForm();

            this.isFormShown = false;

            this.pupulateAddressUi({
                id: '',
                city: '',
                company: '',
                postcode: '',
                lastname: '',
                firstname: '',
                telephone: '',
                countryId: 'US',
                regionId: 0,
                street: ['']
            });

            if (this.isFormShownAddMode) {
                this.isFormShownAddMode = false;

                this.ui.form.hide();
            } else {
                this.isFormShownAddMode = true;

                this.ui.form.show();
            }
        },

        addressChanged: function (selectElement) {
            if (
                typeof this.addressesData === 'undefined'
                || this.addressesData.length === 0
            ) {
                return false;
            }

            this.pupulateAddressUi(
                this.addressesData.find(function (address) {
                    return address.id == selectElement.value;
                })
            );
        },

        pupulateAddressUi: function (addressData) {
            this.ui.id.val(addressData.id);
            this.ui.city.val(addressData.city);
            this.ui.company.val(addressData.company);
            this.ui.postcode.val(addressData.postcode);
            this.ui.lastname.val(addressData.lastname);
            this.ui.firstname.val(addressData.firstname);
            this.ui.telephone.val(addressData.telephone);
            this.ui.country.val(addressData.countryId);

            document.getElementById(this.addressPrefix + 'country')
                .dispatchEvent(new Event('change'));

            this.ui.region.val(addressData.regionId ? addressData.regionId : '');

            for (var i = 0; i < addressData.street.length; i++) {
                $('#' + this.addressPrefix + 'street_' + (i + 1)).val(addressData.street[i]);
            }
        }
    });
});