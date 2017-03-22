<?php use TypistTech\Imposter\Plugin\FunctionalTester;

$I = new FunctionalTester($scenario);

$I->wantToTest('imposer adds classmap autoloads');

$I->openFile('vendor/composer/autoload_classmap.php');
$I->seeInThisFile('MyPlugin\\\\Vendor\\\\Dummy\\\\File\\\\DummyClass');
$I->seeInThisFile('MyPlugin\\\\Vendor\\\\Dummy\\\\Psr4\\\\DummyOne');
$I->seeInThisFile('MyPlugin\\\\Vendor\\\\Dummy\\\\Psr4\\\\DummyTwo');
$I->seeInThisFile('MyPlugin\\\\Vendor\\\\Dummy\\\\Psr4\\\\Sub\\\\DummyOne');
