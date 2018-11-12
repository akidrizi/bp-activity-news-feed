<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit050fde531499340bdc06606e79b70791
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'BP_NewsFeed\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'BP_NewsFeed\\' => 
        array (
            0 => __DIR__ . '/../..' . '/BP_NewsFeed',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit050fde531499340bdc06606e79b70791::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit050fde531499340bdc06606e79b70791::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
