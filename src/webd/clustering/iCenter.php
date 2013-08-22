<?php
namespace webd\clustering;

interface iCenter
{
    public function addPoint(iPoint $point);
    public function setPoints(array $points);
    
    /**
     * Compute the new value (coordinates) of the center
     * Returns nothing
     * Throws exception in case of problem
     */
    public function computeNewValue();
}
?>
