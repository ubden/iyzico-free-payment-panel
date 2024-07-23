<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitcea0afff270a4199f9ddfea7a9605673
{
    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'Iyzipay\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Iyzipay\\' => 
        array (
            0 => __DIR__ . '/..' . '/iyzico/iyzipay-php/src/Iyzipay',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitcea0afff270a4199f9ddfea7a9605673::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitcea0afff270a4199f9ddfea7a9605673::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitcea0afff270a4199f9ddfea7a9605673::$classMap;

        }, null, ClassLoader::class);
    }
}
