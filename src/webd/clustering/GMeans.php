<?php
namespace webd\clustering;

class GMeans
{
    /**
     *
     * @var RnPoint[] 
     */
    public $points;
    
    /**
     *
     * @var RnCenter[] 
     */
    public $centers_possible;
    
    /**
     *
     * @var RnCenter[]
     */
    public $centers_found;
    
    public function run() {
        // Add one center (with all points) to $centers_possible;
        $original_center = $this->points[0]->convertToCenter();
        $original_center->setPoints($this->points);
        $this->centers_possible[] = $original_center;
        
        while(count($this->centers_possible)) {
            // Unqueue the center
            $current_center = array_shift($this->centers_possible);
            
            //Use the points to find 2 new centers
            //var_dump($center);
            $kmeans = new KMeans();
            $kmeans->k = 2;
            $kmeans->n = 20;
            $kmeans->points = $current_center->getPoints();
            $kmeans->run();
            
            // Check projection of points on the line beteween the 2 new centers
            $new_centers = $kmeans->centers;
            $v = $new_centers[0]->sub($new_centers[1]);
            $X = array();
            foreach ($current_center->getPoints() as $point) {
                $X[] = $v->scalarProject($point);
            }
            $X_vect = new \webd\vectors\Vector($X);
            $X_std_norm = $X_vect->standardNormal();
            
            if (! $X_std_norm->isGaussian()) {
                // Previous cluster was not correct
                // Go further, 
                $this->centers_possible[] = $kmeans->centers[0];
                $this->centers_possible[] = $kmeans->centers[1];
                
            } else {
                // Reject split and keep previous center
                // Add previous center to the list of found centers
                $this->centers_found[] = $current_center;
            }
        }
    }
}

?>
