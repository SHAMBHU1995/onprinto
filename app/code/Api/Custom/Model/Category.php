<?php
namespace Api\Custom\Model;

use Api\Custom\Api\CategoryInterface;

class Category  implements \Api\Custom\Api\CategoryInterface
{
    public function __construct(
        \Magento\Catalog\Block\Adminhtml\Category\Tree $adminCategoryTree
     )
     {
        $this->adminCategoryTree = $adminCategoryTree;
     }

    public function list()
    {
        $tree = $this->adminCategoryTree->getTree();
        $code = 1;
        $data =  array('code' => $code , 'category' => $tree );
        echo json_encode($data);die;
    }
}