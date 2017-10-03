<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);
use Src\Middlewares\CorsMW;

$app->add(CorsMW::class);