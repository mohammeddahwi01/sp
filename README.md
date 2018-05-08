Homesinsideout, mibasics, sun&pine.

При установке "с нуля" нужно временно убрать папку app/code/Paradoxlabs, так как этот модуль выдаёт ошибку во время процесса установки. 
После установки магазина папку можно скопировать обратно и запустить команду `setup:upgrade`.

Нужно отключить модуль Amasty Shopby
php bin/magento module:disable Amasty_ShopbySeo Amasty_ShopbyPage Amasty_ShopbyBrand Amasty_ShopbyRoot Amasty_Shopby


Store switcher for index.php:

```
// Enable multiple domains for different stores
$params = $_SERVER;
switch ($_SERVER['HTTP_HOST']) {
    case 'www.homesinsideout.com':
    case 'homesinsideout.com':
        $params[\Magento\Store\Model\StoreManager::PARAM_RUN_CODE] = 'default';
        $params[\Magento\Store\Model\StoreManager::PARAM_RUN_TYPE] = 'store';
        break;
    case 'www.sunandpine.com':
    case 'sunandpine.com':
        $params[\Magento\Store\Model\StoreManager::PARAM_RUN_CODE] = 'sunandpine_en';
        $params[\Magento\Store\Model\StoreManager::PARAM_RUN_TYPE] = 'store';
        break;
    case 'www.mibasic.com':
    case 'mibasic.com':
    default:
        $params = $_SERVER; $params[\Magento\Store\Model\StoreManager::PARAM_RUN_CODE] = 'mibasics_en';
        $params[\Magento\Store\Model\StoreManager::PARAM_RUN_TYPE] = 'store';
}
```

