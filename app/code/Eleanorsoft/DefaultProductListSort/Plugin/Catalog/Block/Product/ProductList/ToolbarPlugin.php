<?php

namespace Eleanorsoft\DefaultProductListSort\Plugin\Catalog\Block\Product\ProductList;

class ToolbarPlugin
{
	const MAGENTO_DEFAULT_SORT_FIELD = 'position';
	
	private $defaultSortField = 'entity_id';
	
	public function afterGetCurrentOrder(\Magento\Catalog\Block\Product\ProductList\Toolbar $subject, $result)
	{
		if ($result == self::MAGENTO_DEFAULT_SORT_FIELD) {
			$result = $this->defaultSortField;
		}
		return $result;
	}
	
	public function afterGetCurrentDirection(\Magento\Catalog\Block\Product\ProductList\Toolbar $subject, $result)
	{
		if ($subject->getCurrentOrder() == $this->defaultSortField) {
			return 'desc';
		}
		return $result;
	}
}