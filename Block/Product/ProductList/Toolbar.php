<?php

namespace SpringImport\CatalogSortOrderDirection\Block\Product\ProductList;

class Toolbar extends \Magento\Catalog\Block\Product\ProductList\Toolbar
{
    /**
     * Default Order direction
     *
     * @var string
     */
    protected $_orderDirection = null;

    /**
     * {@inheritdoc}
     */
    public function getCurrentDirection()
    {
        $dir = $this->_getData('_current_grid_direction');
        if ($dir) {
            return $dir;
        }

        $directions = ['asc', 'desc'];
        $dir = strtolower($this->_toolbarModel->getDirection());
        if (!$dir || !in_array($dir, $directions)) {
            $dir = $this->getOrderDirection();
        }

        if ($dir != $this->_direction) {
            $this->_memorizeParam('sort_direction', $dir);
        }

        $this->setData('_current_grid_direction', $dir);
        return $dir;
    }

    /**
     * Get order direction
     *
     * @return null|string
     */
    protected function getOrderDirection()
    {
        if ($this->_orderDirection === null) {
            $this->_orderDirection = $this->_productListHelper->getDefaultSortDirection();
        }
        return $this->_orderDirection;
    }
}
