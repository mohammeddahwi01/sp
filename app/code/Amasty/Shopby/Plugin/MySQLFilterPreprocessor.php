<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2016 Amasty (https://www.amasty.com)
 * @package Amasty_Shopby
 */

/**
 * Copyright © 2016 Amasty. All rights reserved.
 */

namespace Amasty\Shopby\Plugin;


class MySQLFilterPreprocessor
{
    protected $connection;

    public function __construct(\Magento\Framework\App\ResourceConnection $resourceConnection)
    {
        $this->connection = $resourceConnection->getConnection();
    }

    public function aroundProcess(
        \Magento\CatalogSearch\Model\Adapter\Mysql\Filter\Preprocessor $subject,
        \Closure $closure,
        \Magento\Framework\Search\Request\FilterInterface $filter,
        $isNegation,
        $query
    ) {
        $result = $closure($filter, $isNegation, $query);
        if ($filter->getField() === 'category_ids' && is_array($filter->getValue())) {
            $result = str_replace(
                $this->connection->quoteIdentifier('category_ids'),
                $this->connection->quoteIdentifier('category_ids_index.category_id'),
                $query
            );
        }

        return $result;
    }
}
