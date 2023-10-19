<?php
namespace App\Service;

class Recommendation {
    private $objectId;
    private $quantity=1;

    public function __construct(int $var = null) {
        $this->objectId = $var;
    }

    function set_objectId($id){
        $this->objectId =$id;
    }

    function addQuantity(){
        $this->quantity = $this->quantity+1;
    }

    function getQuantity(){
        return $this->quantity;
    }
}
