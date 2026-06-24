<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Repositories\StudentRepository;

$repo = new StudentRepository();

echo '<pre>';

print_r(
    $repo->all()
);

echo '</pre>';