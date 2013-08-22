<?php
namespace webd\clustering;

class RnCenter extends RnPoint implements iCenter
{
    protected $points = array();
    
    public function addPoint(iPoint $point) {
        $this->points[] = $point;
    }
    
    public function setPoints(array $points) {
        $this->points = $points;
    }
    
    public function getPoints() {
        return $this->points;
    }

    public function computeNewValue() {
        $count = count($this->points);
        
        if ($count == 0) {
            throw new \Exception("Center has no point");
        }
        
        $new_center = new RnCenter($this->points[0]->div($count)->getValue());
        for ($i=1; $i<$count; $i++) {
            $point = $this->points[$i];
            $new_center = $new_center->add($point->div($count));
        }
        $this->value = $new_center->getValue();
    }    
}
?>
