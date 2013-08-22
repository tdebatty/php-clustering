php-clustering
==============

Clustering algorithms for PHP

Usage
-----

```php
use \webd\clustering\KMeans;
use \webd\clustering\RnPoint;

// These examples use points in Rn, but some algorithms (like KMeans)
// support points in non-euclidean spaces
$points = array(
    new RnPoint(array(1, 1)),
    new RnPoint(array(2, 2)),
    new RnPoint(array(2, 3))
);

// Simple KMeans
$kmeans = new KMeans;
$kmeans->k = 2;
$kmeans->n = 10;
$kmeans->points = $points;
$kmeans->run();

var_dump($kmeans->centers);

// GMeans (no need to specify the number of clusters)
$nd = new \webd\stats\NormalDistribution();

// Create points around (1, 1) and (9, 9)
$points = array();
for ($i = 0; $i < 100; $i++) {
    $points[] = new RnPoint($nd->sample()+1, $nd->sample()+1);
    $points[] = new RnPoint($nd->sample()+9, $nd->sample()+9);
}

$gmeans = new GMeans();
$gmeans->points = $points;
$gmeans->run();
```