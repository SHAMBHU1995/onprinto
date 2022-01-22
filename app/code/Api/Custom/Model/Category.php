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

    public function product()
    {
        $json_str = file_get_contents('php://input');
        $json_obj = json_decode($json_str,true);
    
        $token = isset($json_obj['token'])?$json_obj['token']:null;
        $cat = isset($json_obj['cat'])?$json_obj['cat']:null;

        if(!empty($token)){
            $tokenCollection = $this->helperData->authenticateToken($token);
            if(count($tokenCollection) == 0){
                $code = 0;
                $message = "Invalid Api token";
                $data =  array('code' => $code , 'message' => $message );
                echo json_encode($data);die;
      
              }
          }else{
            $code = 0;
            $message = "Access token missing";
            $data =  array('code' => $code , 'message' => $message );
            echo json_encode($data);die;
          }
          if(empty($cat)){
            $code = 0;
            $message = "Invalid parameter";
            $data =  array('code' => $code , 'message' => $message );
            echo json_encode($data);die;
          }
          $result = [];
          if($cat){
            $collection = $this->helperData->getCategoryProducts($cat);
            
            foreach($collection as $product){
                $result[] = $product->getData();
            }
            $code = 1;
            $data =  array('code' => $code , 'product' => $result );
            echo json_encode($data);die;
        }
            
    }
}