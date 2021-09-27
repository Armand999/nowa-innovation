<?php

// autoload_psr4.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'Router\\' => array($baseDir . '/routes'),
    'PHPMailer\\PHPMailer\\' => array($vendorDir . '/phpmailer/phpmailer/src'),
    'Core\\' => array($baseDir . '/core'),
    'Cocur\\Slugify\\' => array($vendorDir . '/cocur/slugify/src'),
    'App\\' => array($baseDir . '/app'),
);