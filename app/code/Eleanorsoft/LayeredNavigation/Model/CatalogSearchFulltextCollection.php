<?php

namespace Eleanorsoft\LayeredNavigation\Model;

/**
 * Class CatalogSearchFulltextCollection
 * Preference, which allows add filters with array values.
 *
 * @package Eleanorsoft\LayeredNavigation\Model
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class CatalogSearchFulltextCollection extends CatalogSearchFulltextCollectionBase
{
    /**
     * Check if array is associative.
     *
     * @param $value
     * @return bool
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function isAssoc($value)
    {
        if (array() === $value) {
            return false;
        }

        return array_keys($value) !== range(0, count($value) - 1);
    }

    /**
     * Allow array values in filters.
     *
     * @param string $field
     * @param null $condition
     * @return $this
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function addFieldToFilter($field, $condition = null)
    {
        if (
            $field == 'visibility'
            || !is_array($condition)
            || $this->isAssoc($condition)
        ) {
            return parent::addFieldToFilter($field, $condition);
        }

        $this->filterBuilder->setField($field);
        $this->filterBuilder->setConditionType('in');
        $this->filterBuilder->setValue($condition);
        $this->searchCriteriaBuilder->addFilter($this->filterBuilder->create());

        return $this;
    }
}
