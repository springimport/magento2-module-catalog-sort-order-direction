<?php

/**
 * Catalog Product List Sortable allowed sortable directions
 */
namespace SpringImport\CatalogSortOrderDirection\Model\Config\Source;

class ListSortDirection implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Catalog config
     *
     * @var \Magento\Catalog\Model\Config
     */
    protected $_catalogConfig;

    /**
     * Construct
     *
     * @param \Magento\Catalog\Model\Config $catalogConfig
     */
    public function __construct(\Magento\Catalog\Model\Config $catalogConfig)
    {
        $this->_catalogConfig = $catalogConfig;
    }

    /**
     * Retrieve option values array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            [
                'label' => __('Ascending'), 'value' => 'asc'
            ],
            [
                'label' => __('Descending'), 'value' => 'desc'
            ],
        ];
        return $options;
    }

    /**
     * Retrieve Catalog Config Singleton
     *
     * @return \Magento\Catalog\Model\Config
     */
    protected function _getCatalogConfig()
    {
        return $this->_catalogConfig;
    }
}
