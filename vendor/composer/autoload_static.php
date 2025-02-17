<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2682c0f8fac16de9ed94435a671149ee
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Asus\\GlobalProjetLaravel\\' => 25,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Asus\\GlobalProjetLaravel\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2682c0f8fac16de9ed94435a671149ee::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2682c0f8fac16de9ed94435a671149ee::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2682c0f8fac16de9ed94435a671149ee::$classMap;

        }, null, ClassLoader::class);
    }
}
