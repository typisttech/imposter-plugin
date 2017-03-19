<?php

declare(strict_types=1);

namespace TypistTech\Imposter\Plugin\Command;

use Composer\Command\BaseCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TypistTech\Imposter\Imposter;
use TypistTech\Imposter\ImposterFactory;

class RunCommand extends BaseCommand
{
    /**
     * @var Imposter
     */
    private $imposter;

    protected function configure()
    {
        $this->setName('imposter:run')
             ->setDescription("Transform all required packages' namespaces into yours")
             ->setHelp(<<<EOT
The <info>imposter:run</info> command goes through all required packages' autoload-ed files, and
prefixes all namespaces with yours, as defined as <info>extra.imposter.namespace</info> in composer.json
EOT
             );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Running Imposter...');
        $io->text('Loading package information from <info>' . getcwd() . '/composer.json</info>');

        $count = count($this->getAutoloads());
        $io->text("Number of autoloads found: <info>$count</info>");

        $progressBar = new ProgressBar($output, $count);
        $progressBar->start();

        $autoloads = $this->getAutoloads();
        array_walk($autoloads, function ($autoload) use ($io, $progressBar) {
            $this->transform($autoload, $io, $progressBar);
        });

        $progressBar->finish();
        $io->newLine();
        $io->text('<info>Done.</info>');
    }

    /**
     * @return string[]
     */
    private function getAutoloads(): array
    {
        return $this->getImposter()->getAutoloads();
    }

    private function getImposter(): Imposter
    {
        if (null === $this->imposter) {
            $this->imposter = ImposterFactory::forProject(getcwd(), ['typisttech/imposter-plugin']);
        }

        return $this->imposter;
    }

    /**
     * @param string       $autoload
     * @param SymfonyStyle $io
     * @param ProgressBar  $progressBar
     *
     * @return void
     */
    private function transform(string $autoload, SymfonyStyle $io, ProgressBar $progressBar)
    {
        $progressBar->clear();
        $io->text(" * Transforming: <comment>$autoload</comment>");
        $progressBar->display();

        $this->getImposter()->transform($autoload);

        $progressBar->advance();
    }
}
