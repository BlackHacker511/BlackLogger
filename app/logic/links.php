<?php

$link = new Framework\Shortener($database);

$links = $link->getAll();
