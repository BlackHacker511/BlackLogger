<?php

$links = $link->getAll();

$hits = 0;

foreach ($links as $l) {
    $hits = $hits + $l->hits;
}
