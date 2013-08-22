<?php
namespace webd\clustering;

/**
 * General KMeans algorithm
 * Initial centers are choosen at random
 * Number of iterations is fixed (no convergence test)
 */
class KMeans
{
    public $k = 2;
    
    /**
     *
     * @var int Maximum number of iterations
     */
    public $n = 10;
    
    /**
     *
     * @var IPoint[]
     */
    public $points = array();
    
    /**
     *
     * @var ICenter[] 
     */
    public $centers = array();
    
    
    public function run() {
        $this->chooseInitialCenters();
        
        for ($i = 0; $i < $this->n; $i++) {
            $this->removePoints();
            $this->assignPoints();
            $this->computeNewCenters();
            
            if ($this->testTermination()) {
                break;
            }
        }
    }
    
    /**
     * Choose initial centers randomly
     */
    protected function chooseInitialCenters() {
        for ($i=0; $i<$this->k; $i++) {
            $this->centers[] = $this->points[mt_rand(0, count($this->points)-1)]->convertToCenter();
        }
    }
    
    protected function removePoints() {
        foreach ($this->centers as $center) {
            $center->setPoints(array());
        }
    }
    
    protected function assignPoints() {
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
        }
    }
    
    /**
     * 
     */
    protected function computeNewCenters() {
        foreach ($this->centers as $key => $center) {
            try {
                $center->computeNewValue();
            } catch (Exception $exc) {
                unset($this->centers[$key]);
            }
        }
    }
    
    /**
     * 
     * @return boolean true if convergence is reached
     */
    protected function testTermination() {
        return false;
    }
}
?>
