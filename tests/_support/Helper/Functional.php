<?php

namespace TypistTech\Imposter\Plugin\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\Lib\Interfaces\DependsOnModule;
use Codeception\Lib\Interfaces\RequiresPackage;
use Codeception\Module;
use Codeception\Module\Cli;
use Codeception\Module\Filesystem;
use Codeception\TestInterface;
use Spatie\TemporaryDirectory\TemporaryDirectory;

class Functional extends Module implements DependsOnModule, RequiresPackage
{
    protected $config = ['composerInstallFlags' => '--no-interaction --no-suggest --quite'];

    protected $dependencyMessage = <<<EOF
Example configuring ComposerProject.
--
modules:
    enabled:
        - \TypistTech\Imposter\Plugin\Helper\Functional:
            composerInstallFlags: '--no-interaction --quiet'
            projectRoot: 'fake-project'
            depends:
                - Cli
                - Filesystem
--
EOF;

    protected $requiredFields = ['projectRoot'];

    /**
     * @var Cli
     */
    private $cli;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var string
     */
    private $tmpProjectDir;

    public function _after(TestInterface $test)
    {
        $this->debugSection('ComposerProject', 'Deleting temporary directory...');

        $this->filesystem->deleteDir($this->tmpProjectDir);

        $this->debugSection('ComposerProject', 'Deleted temporary directory');
    }

    public function _before(TestInterface $test)
    {
        $this->createTmpProjectDir();
        $this->copyProjectRootToTmpProjectDir();

        $this->amInTmpProjectDir();

        $this->runComposerCommand('config repositories.composer-project path ' . codecept_root_dir());
        $this->runComposerCommand('install ' . $this->_getConfig('composerInstallFlags'));
    }

    private function createTmpProjectDir()
    {
        $this->debugSection('ComposerProject', 'Creating temporary directory...');

        $this->tmpProjectDir = (new TemporaryDirectory)->create()->path();

        $this->debugSection('ComposerProject', "Created temporary directory at $this->tmpProjectDir");
    }

    private function copyProjectRootToTmpProjectDir()
    {
        $projectRoot = codecept_data_dir($this->config['projectRoot']);

        $this->debugSection('ComposerProject', "Project root is $projectRoot");
        $this->debugSection('ComposerProject', 'Copying project root to temporary directory');

        $this->filesystem->copyDir(
            $projectRoot,
            $this->tmpProjectDir
        );
    }

    public function amInTmpProjectDir()
    {
        $this->filesystem->amInPath($this->tmpProjectDir);
    }

    public function runComposerCommand(string $command, bool $failNonZero = true)
    {
        $this->debug("> composer $command");
        $this->cli->runShellCommand("composer $command", $failNonZero);
    }

    public function _depends()
    {
        return [
            Cli::class => $this->dependencyMessage,
            Filesystem::class => $this->dependencyMessage
        ];
    }

    public function _inject(Cli $cli, Filesystem $filesystem)
    {
        $this->cli        = $cli;
        $this->filesystem = $filesystem;
    }

    public function _requires()
    {
        return [
            TemporaryDirectory::class => '"spatie/temporary-directory": "^1.1"'
        ];
    }

    public function getTmpProjectDir(): string
    {
        return $this->tmpProjectDir;
    }
}
