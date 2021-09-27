<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit324b757d935b0ea45f4acd76a1c4c0db
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'Router\\' => 7,
        ),
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'C' => 
        array (
            'Core\\' => 5,
            'Cocur\\Slugify\\' => 14,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Router\\' => 
        array (
            0 => __DIR__ . '/../..' . '/routes',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core',
        ),
        'Cocur\\Slugify\\' => 
        array (
            0 => __DIR__ . '/..' . '/cocur/slugify/src',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit324b757d935b0ea45f4acd76a1c4c0db::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit324b757d935b0ea45f4acd76a1c4c0db::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit324b757d935b0ea45f4acd76a1c4c0db::$classMap;

        }, null, ClassLoader::class);
    }
}
