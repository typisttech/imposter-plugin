<?php
/**
 * Imposter Plugin
 *
 * Composer plugin that wraps all composer vendor packages inside your own namespace.
 * Intended for WordPress plugins.
 *
 * @package   TypistTech\Imposter\Plugin
 * @author    Typist Tech <imposter-plugin@typist.tech>
 * @copyright 2017 Typist Tech
 * @license   MIT
 * @see       https://www.typist.tech/projects/imposter-plugin
 */

declare(strict_types=1);

namespace TypistTech\Imposter\Plugin\Command;

use Composer\Command\BaseCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
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
        $output->write('<comment>Running Imposter...</comment>', true);
        $output->write('<comment>======================</comment>', true);
        $output->write('Loading package information from <info>' . getcwd() . '/composer.json</info>', true);

        $count = count($this->getAutoloads());
        $output->write("Imposter operations: <info>$count</info> transformations", true);

        $progressBar = new ProgressBar($output, $count);
        $progressBar->start();

        $autoloads = $this->getAutoloads();
        array_walk($autoloads, function ($autoload) use ($output, $progressBar) {
            $progressBar->clear();
            $output->write(" - Transforming: <comment>$autoload</comment>", true);
            $progressBar->display();

            $this->transform($autoload);

            $progressBar->advance();
        });

        $progressBar->finish();
        $output->write(PHP_EOL);
        $output->write('<info>Done.</info>', true);
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
     * @param string $autoload
     *
     * @return void
     */
    private function transform(string $autoload)
    {
        $this->getImposter()->transform($autoload);
    }
}
