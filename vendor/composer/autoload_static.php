<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite196138b2c8ea1b8bc08518c7bbae047
{
    public static $prefixLengthsPsr4 = array (
        'c' => 
        array (
            'cebe\\markdown\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'cebe\\markdown\\' => 
        array (
            0 => __DIR__ . '/..' . '/cebe/markdown',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite196138b2c8ea1b8bc08518c7bbae047::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite196138b2c8ea1b8bc08518c7bbae047::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}