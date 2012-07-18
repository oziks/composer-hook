<?php

/*
 * Script post install/update for Composer
 *
 * (c) Morgan Brunot <brunot.morgan@gmail.com>
 *
 * Deletes the .git directory of symfony vendors case.
 * In case if you push a vendors on project repository.
 */

namespace My\ProjectBundle\Composer;

use Symfony\Component\ClassLoader\ClassCollectionLoader;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\PhpExecutableFinder;

/**
 * @author Morgan Brunot <brunot.morgan@gmail.com>
 */
class ScriptHandler
{
    public static function removeVendorGitDirectory($event)
    {
        $options = self::getOptions($event);
        $vendorDir = $options['symfony-vendor-dir'];

        if (!is_dir($vendorDir)) {
            echo 'The symfony-vendor-dir ('.$vendorDir.') specified in composer.json was not found in '.getcwd().', can not remove git repository on vendor.'.PHP_EOL;

            return;
        }

        static::executeRemoveVendorGitDirectory($vendorDir);
    }

    protected static function executeRemoveVendorGitDirectory($vendorDir)
    {
        $vendorDir = escapeshellarg(trim($vendorDir, DIRECTORY_SEPARATOR));
        $cmd       = sprintf('find ./%s/ -type d -name \.git -exec rm -rf {} \;', $vendorDir);

        $process = new Process($cmd, null, null, null, 3600);
        $process->run();

        if (!$process->isSuccessful()) {
            echo 'The vendor git directories have been deleted.'.PHP_EOL;
        }
    }

    protected static function getOptions($event)
    {
        $options = array_merge(array(
            'symfony-app-dir'        => 'app',
            'symfony-web-dir'        => 'web',
            'symfony-vendor-dir'     => 'vendor',
            'symfony-assets-install' => 'hard'
        ), $event->getComposer()->getPackage()->getExtra());

        $options['symfony-assets-install'] = getenv('SYMFONY_ASSETS_INSTALL') ?: $options['symfony-assets-install'];

        return $options;
    }

    protected static function getPhp()
    {
        $phpFinder = new PhpExecutableFinder;
        if (!$phpPath = $phpFinder->find()) {
            throw new \RuntimeException('The php executable could not be found, add it to your PATH environment variable and try again');
        }

        return $phpPath;
    }
}