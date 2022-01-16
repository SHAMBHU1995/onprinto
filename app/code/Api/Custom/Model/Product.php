<?php
namespace Api\Custom\Model;

use Api\Custom\Api\ProductInterface;

class Product  implements \Api\Custom\Api\ProductInterface
{

  public function __construct(
    \Api\Custom\Helper\Data $helperData
  ) {
    $this->helperData = $helperData;
  }


  public function search() {

    $json_str = file_get_contents('php://input');
    $json_obj = json_decode($json_str,true);

    $token = isset($json_obj['token'])?$json_obj['token']:null;
    $sku = isset($json_obj['sku'])?$json_obj['sku']:null;
    $name = isset($json_obj['name'])?$json_obj['name']:null;

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
    if(empty($sku) && empty($name)){
      $code = 0;
      $message = "Invalid parameter";
      $data =  array('code' => $code , 'message' => $message );
      echo json_encode($data);die;
    }
    $result = [];
    if($sku || $name){
      $collection = $this->helperData->getProducts($sku, $name);
     
      foreach($collection as $product){
        $result[] = $product->getData();
      }
      $code = 1;
      $data =  array('code' => $code , 'product' => $result );
      echo json_encode($data);die;
    }

  }

}

