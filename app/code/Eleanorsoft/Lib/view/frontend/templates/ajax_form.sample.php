<?php
/**
 * ajax_form.sample.php
 * Sample ajax form template file.
 */
?>
<div class="ajax-form" data-bind="scope: 'ajaxForm'">
    <form
        id="change-customer-personal-info-form"
        class="form contact"
        style="display: none;"
        action="<?php echo $block->getUrl('customer/account/editPost'); ?>"
        method="post"
        data-hasrequired="<?php echo __('* Required Fields') ?>"
        data-mage-init='{"validation":{}}'
        data-bind="submit: submitForm"
    >
        <?php echo $block->getBlockHtml('formkey'); ?>
        <!-- ko template: 'Eleanorsoft_Lib/ajax-form-messages.html' --><!-- /ko -->
        <fieldset class="fieldset">
            <div class="field firstname required">
                <label class="label" for="firstname">
                    <span><?php echo __('First Name') ?></span>
                </label>
                <div class="control">
                    <input
                        id="firstname"
                        class="input-text"
                        name="firstname"
                        type="text"
                        title="<?php echo __('First Name') ?>"
                        value="<?php echo $block->escapeHtml($block->getCustomer()->getFirstname()); ?>"
                        data-validate="{required:true}"
                    />
                </div>
            </div>
            <div class="field lastname required">
                <label class="label" for="lastname">
                    <span><?php echo __('Last Name') ?></span>
                </label>
                <div class="control">
                    <input
                        id="lastname"
                        class="input-text"
                        name="lastname"
                        type="text"
                        title="<?php echo __('Last Name') ?>"
                        value="<?php echo $block->escapeHtml($block->getCustomer()->getLastname()); ?>"
                        data-validate="{required:true}"
                    />
                </div>
            </div>
            <div class="field email required">
                <label class="label" for="email">
                    <span><?php echo __('Email') ?></span>
                </label>
                <div class="control">
                    <input
                        id="email"
                        class="input-text"
                        name="email"
                        type="email"
                        title="<?php echo __('Email') ?>"
                        value="<?php echo $block->escapeHtml($block->getCustomer()->getEmail()); ?>"
                        data-validate="{required:true, 'validate-email':true}"
                    />
                </div>
            </div>
            <div class="field current-password required">
                <label class="label" for="current-password">
                    <span><?php echo __('Current Password') ?></span>
                </label>
                <div class="control">
                    <input
                        id="current-password"
                        class="input-text"
                        name="current_password"
                        type="password"
                        title="<?php echo __('Current Password') ?>"
                        value=""
                        data-validate="{required:true}"
                    />
                </div>
            </div>
        </fieldset>
        <div class="actions-toolbar">
            <div class="primary">
                <button type="submit" title="<?php echo __('Save Changes') ?>" class="action submit primary">
                    <span><?php echo __('Save Changes') ?></span>
                </button>
            </div>
        </div>
    </form>
</div>
<script type="text/x-magento-init">
	{
		"*": {
			"Magento_Ui/js/core/app": {
				"components": {
					"ajaxForm": {
						"component": "Eleanorsoft_Lib/js/ajax-form",
						"beforeSend": "function (jForm) { alert('Some Content Here'); return false; }"
					}
				}
			}
		}
	}
</script>