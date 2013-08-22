<?php
namespace webd\clustering;

class RnPoint extends \webd\vectors\Vector implements iPoint
{
    public function distanceTo(iCenter $center) {
        return $this->sub($center)->norm();
    }
    
    public function convertToCenter() {
        return new RnCenter($this->value);
    }
}
?>
