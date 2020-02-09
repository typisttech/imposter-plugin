<?php

declare(strict_types=1);

namespace TypistTech\Imposter\Plugin;

use Composer\Package\RootPackageInterface;
use RuntimeException;
use TypistTech\Imposter\ImposterFactory;

class AutoloadMerger
{
    public static function run(RootPackageInterface $package): void
    {
        $autoload = $package->getAutoload();
        $autoload = array_merge_recursive($autoload, [
            'classmap' => static::getImposterAutoloads(),
        ]);

        $package->setAutoload($autoload);
    }

    /**
     * @return string[]
     * @todo [Help Wanted] Think of a better way to handle file not found during installation
     */
    protected static function getImposterAutoloads(): array
    {
        try {
            $cwd = getcwd();
            $imposter = ImposterFactory::forProject($cwd, ['typisttech/imposter-plugin']);

            return array_map(function ($path) use ($cwd): string {
                return str_replace($cwd . '/', '', $path);
            }, $imposter->getAutoloads());
        } catch (RuntimeException $exception) {
            return [];
        }
    }
}
