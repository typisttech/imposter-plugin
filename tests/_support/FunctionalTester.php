<?php

namespace TypistTech\Imposter\Plugin;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = null)
 *
 * @SuppressWarnings(PHPMD)
 */
class FunctionalTester extends \Codeception\Actor
{
    use _generated\FunctionalTesterActions;

    /**
     * Define custom actions here
     */

    public function assertTransformed(string $path)
    {
        $this->openFile($path);

        $this->dontSeeInThisFile('namespace Dummy');
        $this->dontSeeInThisFile('use Dummy');
        $this->dontSeeInThisFile('use OtherDummy');
        $this->dontSeeInThisFile('use AnotherDummy');

        $this->seeInThisFile('namespace MyPlugin\Vendor\Dummy');
        $this->seeInThisFile('use MyPlugin\Vendor\Dummy\SubOtherDummy;');
        $this->seeInThisFile('use MyPlugin\Vendor\OtherDummy\SubOtherDummy;');
        $this->seeInThisFile('use MyPlugin\Vendor\AnotherDummy\{');
    }


    public function assertNotTransformed(string $path)
    {
        $this->openFile($path);

        $this->seeInThisFile('namespace Dummy');
        $this->seeInThisFile('use Dummy');
        $this->seeInThisFile('use OtherDummy');
        $this->seeInThisFile('use AnotherDummy');

        $this->dontSeeInThisFile('namespace MyPlugin\Vendor\Dummy');
        $this->dontSeeInThisFile('use MyPlugin\Vendor\Dummy\SubOtherDummy;');
        $this->dontSeeInThisFile('use MyPlugin\Vendor\OtherDummy\SubOtherDummy;');
        $this->dontSeeInThisFile('use MyPlugin\Vendor\AnotherDummy\{');
    }
}
