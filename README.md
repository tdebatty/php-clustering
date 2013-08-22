php-clustering
==============

Clustering algorithms for PHP

Usage
-----

```php
use \webd\clustering\KMeans;
use \webd\clustering\RnPoint;

$kmeans = new KMeans;
$kmeans->k = 2;
$kmeans->n = 10;

$points = array(
    new RnPoint(array(1, 1)),
    new RnPoint(array(2, 2)),
    new RnPoint(array(2, 3))
);

$kmeans->points = $points;

$kmeans->run();

var_dump($kmeans->centers);
```