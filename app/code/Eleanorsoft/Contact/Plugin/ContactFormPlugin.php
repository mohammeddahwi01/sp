<?php

namespace Eleanorsoft\Contact\Plugin;

use \Magento\Framework\UrlInterface;
use \Magento\Contact\Block\ContactForm;
use \Eleanorsoft\Lib\Helper\Captcha as CaptchaHelper;
use \Eleanorsoft\Contact\Helper\Data as ModuleHelper;

/**
 * Class ContactForm
 * todo: What is its purpose? What does it do?
 *
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class ContactFormPlugin
{
    /**
     * @var UrlInterface
     */
    protected $urlInterface;

    /**
     * @var ModuleHelper
     */
    protected $moduleHelper;

    /**
     * @var CaptchaHelper
     */
    protected $captchaHelper;

    public function __construct(
        UrlInterface $urlInterface,
        ModuleHelper $moduleHelper,
        CaptchaHelper $captchaHelper
    ) {
        $this->urlInterface = $urlInterface;
        $this->moduleHelper = $moduleHelper;
        $this->captchaHelper = $captchaHelper;
    }

    public function beforeToHtml(ContactForm $subject)
    {
        $subject->setData(CaptchaHelper::HELPER_FIELD_NAME, $this->captchaHelper);
    }

    public function afterGetFormAction(ContactForm $subject, $result)
    {
        return $this->moduleHelper->isModuleEnabled()
            ? $this->urlInterface->getUrl('eleanorsoft_contact/index/post')
            : $result;
    }
}
