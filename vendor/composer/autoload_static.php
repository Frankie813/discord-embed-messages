<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit690a7581f81304ea6b24a4b59b9e48f5
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Frankie813\\DiscordEmbedMessages\\' => 32,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Frankie813\\DiscordEmbedMessages\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit690a7581f81304ea6b24a4b59b9e48f5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit690a7581f81304ea6b24a4b59b9e48f5::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit690a7581f81304ea6b24a4b59b9e48f5::$classMap;

        }, null, ClassLoader::class);
    }
}
