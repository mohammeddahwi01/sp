<?php


namespace VladimirPopov\WebForms\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\Context;
use Zend\Http\PhpEnvironment\Request;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const DKEY = 'WF1DM';
    const SKEY = 'WFSRV';

    protected $storeManager;

    public function __construct(
        Context $context,
        \Magento\Store\Model\StoreManager $storeManager
    )
    {
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    protected function getDomain($url)
    {
        $url = str_replace(array('http://', 'https://', '/'), '', $url);
        $tmp = explode('.', $url);
        $cnt = count($tmp);

        if (empty($tmp[$cnt - 2]) || empty($tmp[$cnt - 1])) return $url;

        $suffix = $tmp[$cnt - 2] . '.' . $tmp[$cnt - 1];

        $exceptions = array(
            'com.au', 'com.br', 'com.bz', 'com.ve', 'com.gp',
            'com.ge', 'com.eg', 'com.es', 'com.ye', 'com.kz',
            'com.cm', 'net.cm', 'com.cy', 'com.co', 'com.km',
            'com.lv', 'com.my', 'com.mt', 'com.pl', 'com.ro',
            'com.sa', 'com.sg', 'com.tr', 'com.ua', 'com.hr',
            'com.ee', 'ltd.uk', 'me.uk', 'net.uk', 'org.uk',
            'plc.uk', 'co.uk', 'co.nz', 'co.za', 'co.il',
            'co.jp', 'ne.jp', 'net.au', 'com.ar'
        );

        if (in_array($suffix, $exceptions))
            return $tmp[$cnt - 3] . '.' . $tmp[$cnt - 2] . '.' . $tmp[$cnt - 1];

        return $suffix;
    }

    public function verify($domain, $checkstr)
    {

        $base = $this->getDomain(parse_url($this->storeManager->getStore(0)->getConfig('web/unsecure/base_url'), PHP_URL_HOST));
        return false;
    }

    private function verifyIpMask($data, $checkstr)
    {
        if (!is_array($data)) {
            $data = array($data);
        }
        foreach ($data as $name) {
            $ipdata = explode('.', gethostbyname($name));
            if (isset($ipdata[3])) $ipdata[3] = '*';
            $mask = implode('.', $ipdata);

            if (isset($ipdata[2])) $ipdata[2] = '*';
            $mask = implode('.', $ipdata);
        }
        return false;
    }

    public function isProduction()
    {
        $serial = $this->getDomain($this->scopeConfig->getValue('web/unsecure/base_url', ScopeInterface::SCOPE_STORE));

        // check for local environment
        if ($this->isLocal()) return false;

        $domain = $this->getDomain($this->getServer());
        $domain2 = $this->getDomain($this->scopeConfig->getValue('web/unsecure/base_url', ScopeInterface::SCOPE_STORE));
        return true;
    }

    public function checkStoreCode($storeCode)
    {
        if (!$storeCode) return false;
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $storeTableName = $connection->getTableName('store');
        $select = $connection->select()->from($storeTableName)->where('code = ?', $storeCode)->limit(100);
        $query = $connection->query($select);
        return count($query->fetchAll()) > 0;
    }

    public function isLocal()
    {
        $domain = $this->getDomain($this->getServer());

        return substr($domain, -6) == '.local' ||
            substr($domain, -4) == '.dev' ||
            $this->getServer() == 'localhost' ||
            substr($this->getServer(), -7) == '.xip.io';
    }

    public function getServer($param = 'SERVER_NAME')
    {
        $request = new Request;
        return $request->getServer($param);
    }

    public function getNote()
    {
        if ($this->scopeConfig->getValue('webforms/license/serial', ScopeInterface::SCOPE_STORE)) {
            return __('WebForms Professional Edition license number is not valid for store domain.');
        }
        return __('License serial number for WebForms Professional Edition is missing.');
    }

    public function isInEmailStoplist($email)
    {
        if (!$email) return false;

        $stoplist = preg_split("/[\s\n,;]+/", $this->scopeConfig->getValue('webforms/email/stoplist'));

        $flag = false;
        foreach ($stoplist as $blocked_email) {
            $pattern = trim($blocked_email);

            // clear global modifier
            if (substr($pattern, 0, 1) == '/' && substr($pattern, -2) == '/g') $pattern = substr($pattern, 0, strlen($pattern) - 1);

            $status = @preg_match($pattern, "Test");
            if ($status !== false) {
                $validate = new \Zend_Validate_Regex($pattern);
                if ($validate->isValid($email))
                    $flag = true;
            }
            if ($email == $blocked_email) return true;
        }
        return $flag;
    }
}