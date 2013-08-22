<?php
namespace webd\clustering;

/**
 * KMeans No Initial Centers
 * Does not choose initial centers
 * You have to give them yourself with addCenter(iCenter)
 */
class KMeansNIC extends KMeans
{
    protected function chooseInitialCenters() {
        // do nothing...
    }
    
    public function addCenter(iCenter $center) {
        $this->centers[] = $center;
    }
}

?>
