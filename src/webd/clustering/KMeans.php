<?php

namespace webd\clustering;

function rand_gauss() {
    do {
        $x1 = 2.0 * ranf() - 1.0;
        $x2 = 2.0 * ranf() - 1.0;
        $w = $x1 * $x1 + $x2 * $x2;
    } while ($w >= 1.0);

    $w = sqrt((-2.0 * log($w) ) / $w);
    $y1 = $x1 * $w;
    return $y1;
}

function ranf() {
    return mt_rand() / mt_getrandmax();
}

class Point extends \webd\vectors\Vector
{    
    /**
     * Compute euclidian distance to point $to
     * @param Point $to
     * @return double
     */
    public function distanceTo(Point $to)
    {
        $delta = $this - $to;
        return $delta->length();
    }
    
    
    public static function create($center_x, $center_y, $count) {
        $points = array();
        for ($i = 0; $i<$count; $i++) {
            $points[] = new Point(rand_gauss() + $center_x, rand_gauss() + $center_y);
        }
        return $points;
    }
    
    
}

class Center extends Point
{
    public $points = array();
    
    public function addPoint(Point $point) {
        $this->points[] = $point;
    }
    
    /**
     * 
     * @return null if this center has no point
     */
    public function computeNewValue() {
        if (count($this->points) == 0) {
            return null;
        }
        
        $new_center = new Center($this->points[0]->getValue());
        
        foreach ($this->points as $point) {
            $new_center = $new_center + $point;
        }

        if (count($this->points)) {
            $new_center = $new_center / count($this->points);
        }
        
        return $new_center;
    }
}

class KMeans
{
    public $k = 10;
    public $n = 10;
    public $points = array();
    public $centers = array();
    
    
    public function compute() {
        $this->_init();
        
        /* @var $point Point */
        for ($i = 0; $i < $this->n; $i++) {
            echo "Iteration $i\n";
            echo "-------------\n";
            
            $average_distance = 0;
            foreach ($this->points as $point) {
                $shortest = 0;
                $shortest_distance = PHP_INT_MAX;
                foreach ($this->centers as $center_id => $center) {
                    $distance = $point->distanceTo($center);
                    if ($distance < $shortest_distance) {
                        $shortest_distance = $distance;
                        $shortest = $center_id;
                    }
                }
                $this->centers[$shortest]->addPoint($point);
                $average_distance += $shortest_distance / count($this->points);
            }

            // Compute new centers
            $new_centers = array();
            for ($j=0; $j<count($this->centers); $j++) {
                
                $new_center = $this->centers[$j]->computeNewValue();
                if (!is_null($new_center)) {
                    $new_centers[] = $new_center;
                    $new_center->display();
                }
            }
            $this->centers = $new_centers;
            
            echo "Average distance: $average_distance\n\n";
        }
    }
    
    private function _init() {
        for ($i = 0; $i < $this->k; $i++) {
            $this->centers[] = new Center($this->points[$i]->getValue());
        }
    }
}
?>
