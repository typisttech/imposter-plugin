<?php use TypistTech\Imposter\Plugin\FunctionalTester;

$I = new FunctionalTester($scenario);
$I->wantToTest('$ composer imposter:run');

$I->wantTo('reinstall packages without plugins');
$I->deleteDir('vendor');
$I->runComposerCommand('install --no-plugins --quiet --prefer-dist');

$I->wantTo('check newly installed files not been transformed by imposter');
$I->assertNotTransformed('vendor/dummy/dummy/DummyClass.php');
$I->assertNotTransformed('vendor/dummy/dummy-psr4/src/DummyOne.php');
$I->assertNotTransformed('vendor/dummy/dummy-psr4/src/DummyTwo.php');
$I->assertNotTransformed('vendor/dummy/dummy-psr4/src/Sub/DummyOne.php');

$I->wantToTest('$ composer imposter:run can be ran twice');
$I->runComposerCommand('imposter:run');
$I->runComposerCommand('imposter:run');

$I->openFile('vendor/dummy/dummy/DummyClass.php');
$I->dontSeeInThisFile('MyPlugin\Vendor\MyPlugin\Vendor');

$I->openFile('vendor/dummy/dummy-psr4/src/DummyOne.php');
$I->dontSeeInThisFile('MyPlugin\Vendor\MyPlugin\Vendor');

$I->openFile('vendor/dummy/dummy-psr4/src/DummyTwo.php');
$I->dontSeeInThisFile('MyPlugin\Vendor\MyPlugin\Vendor');

$I->openFile('vendor/dummy/dummy-psr4/src/Sub/DummyOne.php');
$I->dontSeeInThisFile('MyPlugin\Vendor\MyPlugin\Vendor');

$I->assertTransformed('vendor/dummy/dummy/DummyClass.php');
$I->assertTransformed('vendor/dummy/dummy-psr4/src/DummyOne.php');
$I->assertTransformed('vendor/dummy/dummy-psr4/src/DummyTwo.php');
$I->assertTransformed('vendor/dummy/dummy-psr4/src/Sub/DummyOne.php');
