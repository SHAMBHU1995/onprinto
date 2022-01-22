<?php
namespace Api\Custom\Model;

use Api\Custom\Api\CategoryInterface;

class Category  implements \Api\Custom\Api\CategoryInterface
{
    public function __construct(
        \Magento\Catalog\Block\Adminhtml\Category\Tree $adminCategoryTree,
        \Api\Custom\Helper\Data $helperData
     )
     {
        $this->adminCategoryTree = $adminCategoryTree;
        $this->helperData = $helperData;
     }

    public function list()
    {
        $tree = $this->adminCategoryTree->getTree();
        $code = 1;
        $data =  array('code' => $code , 'category' => $tree );
        echo json_encode($data);die;
    }

}