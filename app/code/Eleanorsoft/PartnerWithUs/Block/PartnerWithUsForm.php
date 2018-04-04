<?php

namespace Eleanorsoft\PartnerWithUs\Block;

use Magento\Framework\View\Element\Template;
use Eleanorsoft\Lib\Helper\Captcha as CaptchaHelper;

/**
 * Main Partner With Us form block
 */
class PartnerWithUsForm extends Template
{
    /**
     * @var CaptchaHelper
     */
    protected $captchaHelper;

    /**
     * @param Template\Context $context
     * @param CaptchaHelper $captchaHelper
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CaptchaHelper $captchaHelper,
        array $data = []
    ) {
        $this->_isScopePrivate = true;
        $this->captchaHelper = $captchaHelper;

        parent::__construct($context, $data);
    }

    /**
     * Get captcha helper.
     *
     * @return CaptchaHelper
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getCaptchaHelper()
    {
        return $this->captchaHelper;
    }

    /**
     * Returns action url for partner with us form
     *
     * @return string
     */
    public function getFormAction()
    {
        return $this->getUrl('eleanorsoft_partner_with_us/index/post', ['_secure' => true]);
    }
}
