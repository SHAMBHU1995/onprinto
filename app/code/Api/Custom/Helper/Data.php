<?php

namespace Api\Custom\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    public function __construct(
        \Magento\Integration\Model\ResourceModel\Oauth\Token\CollectionFactory $tokenModelCollectionFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
    ) {
        $this->tokenModelCollectionFactory = $tokenModelCollectionFactory;
        $this->_productCollectionFactory = $productCollectionFactory;
    }

/**
 * Undocumented function
 *
 * @param [type] $token
 * @return void
 */
    public function authenticateToken($token)
    {
        $tokenCollection = $this->tokenModelCollectionFactory->create()->addFieldToFilter('token', ['eq' => $token])
                                                                    ->addFieldToFilter('revoked', ['eq' => 0]);
        return $tokenCollection;
    }

/**
 * Undocumented function
 *
 * @param [type] $sku
 * @param [type] $name
 * @return void
 */
    public function getProducts($sku = null, $name = null)
    {
        $collection = $this->_productCollectionFactory->create()
                    ->addAttributeToSelect('*')
                    ->addAttributeToFilter('status', array('eq' => 1))
                    ->addAttributeToFilter('visibility', array('eq' => 4))
                    ->addAttributeToFilter('sku', array('like' => $sku.'%'))
                    ->addAttributeToFilter('name', array('like' => $name.'%'))
                    ->addStoreFilter()
                    ->load();
        return $collection;
    }
}