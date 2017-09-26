<?php

// @codingStandardsIgnoreFile

namespace SpringImport\CatalogSortOrderDirection\Helper\Product;

/**
 * Class ProductList
 */
class ProductList extends \Magento\Catalog\Helper\Product\ProductList
{
    /**
     * Get default sort direction
     *
     * @return null|string
     */
    public function getDefaultSortDirection()
    {
        return $this->scopeConfig->getValue(
            \SpringImport\CatalogSortOrderDirection\Model\Config::XML_PATH_LIST_DEFAULT_SORT_DIRECTION,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
