<?php

namespace SpringImport\CatalogSortOrderDirection\Plugin;

use Magento\Catalog\Helper\Product\ProductList;
use Magento\Catalog\Model\Product\ProductList\Toolbar as ToolbarModel;

class ToolbarPlugin
{
    /**
     * Default direction
     *
     * @var string
     */
    protected $_direction = ProductList::DEFAULT_SORT_DIRECTION;

    /**
     * Catalog session
     *
     * @var \Magento\Catalog\Model\Session
     */
    protected $_catalogSession;

    /**
     * @var ToolbarModel
     */
    protected $_toolbarModel;

    /**
     * @var bool $_paramsMemorizeAllowed
     */
    protected $_paramsMemorizeAllowed = true;

    /**
     * Catalog config
     *
     * @var \Magento\Catalog\Model\Config
     */
    protected $_catalogConfig;

    /**
     * @var ProductList
     */
    protected $_productListHelper;

    /**
     * Default Order direction
     *
     * @var string
     */
    protected $_orderDirection = null;

    /**
     * @param \Magento\Catalog\Model\Session $catalogSession
     * @param ToolbarModel $toolbarModel
     * @param \Magento\Catalog\Model\Config $catalogConfig
     * @param ProductList $productListHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Catalog\Model\Session $catalogSession,
        ToolbarModel $toolbarModel,
        \Magento\Catalog\Model\Config $catalogConfig,
        ProductList $productListHelper
    ) {
        $this->_catalogSession = $catalogSession;
        $this->_toolbarModel = $toolbarModel;
        $this->_catalogConfig = $catalogConfig;
        $this->_productListHelper = $productListHelper;
    }

    /**
     * @param \Magento\Catalog\Block\Product\ProductList\Toolbar $subject
     * @param callable $proceed
     * @return mixed|null|string
     */
    public function aroundGetCurrentDirection(
        \Magento\Catalog\Block\Product\ProductList\Toolbar $subject,
        callable $proceed
    ) {
        $dir = $subject->getData('_current_grid_direction');
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

        $subject->setData('_current_grid_direction', $dir);
        return $proceed();
    }

    /**
     * Set default sort direction
     *
     * @param string $dir
     * @return $this
     */
    public function afterSetDefaultDirection(
        \Magento\Catalog\Block\Product\ProductList\Toolbar $subject,
        $dir
    ) {
        $this->_direction = $dir;
    }

    /**
     * Get order field
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

    /**
     * Memorize parameter value for session
     *
     * @param string $param parameter name
     * @param mixed $value parameter value
     * @return $this
     */
    protected function _memorizeParam($param, $value)
    {
        if ($this->_paramsMemorizeAllowed && !$this->_catalogSession->getParamsMemorizeDisabled()) {
            $this->_catalogSession->setData($param, $value);
        }
        return $this;
    }
}
