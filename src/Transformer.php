<?php

declare(strict_types=1);

namespace TypistTech\Imposter\Plugin;

use Composer\IO\IOInterface;
use TypistTech\Imposter\ImposterFactory;

class Transformer
{
    public static function run(IOInterface $io): void
    {
        // Print an empty line to separate imposter outputs.
        $io->write('', true);
        $io->write('', true);
        $io->write('<info>Running Imposter...</info>', true);
        $io->write('<info>======================</info>', true);
        $io->write('Loading package information from <comment>' . getcwd() . '/composer.json</comment>', true);

        $imposter = ImposterFactory::forProject(getcwd(), ['typisttech/imposter-plugin']);

        $autoloads = $imposter->getAutoloads();
        $count = count($autoloads);
        $index = 1;
        foreach ($autoloads as $autoload) {
            $io->write(" - <comment>$index/$count</comment>: Transforming $autoload", true);
            $imposter->transform($autoload);
            $index++;
        }

        $io->write('<info>Success: Imposter transformed vendor files.</info>', true);

        $invalidAutoloads = $imposter->getInvalidAutoloads();
        if (! empty($invalidAutoloads)) {
            $invalidAutoloadsCount = count($invalidAutoloads);
            $io->writeError('', true);
            $io->writeError(
                // phpcs:ignore Generic.Files.LineLength.TooLong
                "<warning>Warning: Imposter failed to transformed $invalidAutoloadsCount of the autoload path(s).</warning>",
                true
            );

            foreach ($invalidAutoloads as $invalidAutoload) {
                $io->writeError(" - $invalidAutoload", true);
            }
        }

        // Print empty lines to separate imposter outputs.
        $io->write('', true);
        $io->write('', true);
    }
}
