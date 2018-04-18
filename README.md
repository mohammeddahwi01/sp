Homesinsideout, mibasics, sun&pine.

При установке "с нуля" нужно временно убрать папку app/code/Paradoxlabs, так как этот модуль выдаёт ошибку во время процесса установки. 
После установки магазина папку можно скопировать обратно и запустить команду `setup:upgrade`.

Нужно отключить модуль Amasty Shopby
php bin/magento module:disable Amasty_ShopbySeo Amasty_ShopbyPage Amasty_ShopbyBrand Amasty_ShopbyRoot Amasty_Shopby

