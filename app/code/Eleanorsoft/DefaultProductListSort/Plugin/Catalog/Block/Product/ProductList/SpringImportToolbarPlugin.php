<?php

namespace Eleanorsoft\DefaultProductListSort\Plugin\Catalog\Block\Product\ProductList;

class SpringImportToolbarPlugin
{

	const MAGENTO_DEFAULT_SORT_FIELD = 'position';
	
	private $defaultSortField = 'entity_id';

	public function afterLoadAvailableOrdersForView(\SpringImport\CatalogDropdownSort\Block\Product\ProductList\Toolbar $subject, $result)
	{
		$result['entity_id'] = 'New items';
		$options = array('entity_id' => 'New items');
		foreach ($result as $k=>$v) {
			$options[$k] = $v;
		}
		return $options;
	}
	
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