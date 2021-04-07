<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit42f5eba11565d0d3bc5a64007be21928
{
    public static $files = array (
        'def43f6c87e4f8dfd0c9e1b1bab14fe8' => __DIR__ . '/..' . '/symfony/polyfill-iconv/bootstrap.php',
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'Z' => 
        array (
            'ZBateson\\MbWrapper\\' => 19,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Polyfill\\Iconv\\' => 23,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ZBateson\\MbWrapper\\' => 
        array (
            0 => __DIR__ . '/..' . '/zbateson/mb-wrapper/src',
        ),
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Polyfill\\Iconv\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-iconv',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit42f5eba11565d0d3bc5a64007be21928::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit42f5eba11565d0d3bc5a64007be21928::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit42f5eba11565d0d3bc5a64007be21928::$classMap;

        }, null, ClassLoader::class);
    }
}
