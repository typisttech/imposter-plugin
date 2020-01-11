# Imposter Plugin

[![Packagist](https://img.shields.io/packagist/v/typisttech/imposter-plugin.svg)](https://packagist.org/packages/typisttech/imposter-plugin)
[![Packagist](https://img.shields.io/packagist/dt/typisttech/imposter-plugin.svg)](https://packagist.org/packages/typisttech/imposter-plugin)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/typisttech/imposter-plugin.svg)](https://packagist.org/packages/typisttech/imposter-plugin)
[![CircleCI](https://circleci.com/gh/TypistTech/imposter-plugin.svg?style=svg)](https://circleci.com/gh/TypistTech/imposter-plugin)
[![License](https://img.shields.io/github/license/TypistTech/imposter-plugin.svg)](https://github.com/TypistTech/imposter-plugin/blob/master/LICENSE.md)
[![GitHub Sponsor](https://img.shields.io/badge/Sponsor-GitHub-ea4aaa)](https://github.com/sponsors/TangRufus)
[![Sponsor via PayPal](https://img.shields.io/badge/Sponsor-PayPal-blue.svg)](https://typist.tech/donate/imposter-plugin/)
[![Hire Typist Tech](https://img.shields.io/badge/Hire-Typist%20Tech-ff69b4.svg)](https://typist.tech/contact/)

Wrapping all composer vendor packages inside your own namespace. Intended for WordPress plugins.
Imposter Plugin is a composer plugin wrapper for [Imposter](https://github.com/TypistTech/imposter/).

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->


- [Why?](#why)
- [Install](#install)
- [Usage](#usage)
  - [Sit Back and Relax](#sit-back-and-relax)
  - [composer imposter:run](#composer-imposterrun)
- [Frequently Asked Questions](#frequently-asked-questions)
  - [What can I find more information?](#what-can-i-find-more-information)
  - [How about not hooking into composer commands?](#how-about-not-hooking-into-composer-commands)
  - [Do you have real life examples that use this composer plugin?](#do-you-have-real-life-examples-that-use-this-composer-plugin)
  - [Will you add support for older PHP versions?](#will-you-add-support-for-older-php-versions)
  - [It looks awesome. Where can I find some more goodies like this?](#it-looks-awesome-where-can-i-find-some-more-goodies-like-this)
  - [This package isn't on wp.org. Where can I give a :star::star::star::star::star: review?](#this-package-isnt-on-wporg-where-can-i-give-a-starstarstarstarstar-review)
- [Sponsoring :heart:](#sponsoring-heart)
  - [GitHub Sponsors Matching Fund](#github-sponsors-matching-fund)
  - [Why don't you hire me?](#why-dont-you-hire-me)
  - [Want to help in other way? Want to be a sponsor?](#want-to-help-in-other-way-want-to-be-a-sponsor)
- [Alternatives](#alternatives)
- [Running the Tests](#running-the-tests)
- [Feedback](#feedback)
- [Change log](#change-log)
- [Security](#security)
- [Credits](#credits)
- [License](#license)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Why?

Because of the lack of dependency management in WordPress, if two plugins bundled conflicting versions of the same package, hard-to-reproduce bugs arise.
Monkey patching composer vendor packages, wrapping them inside your own namespace is a less-than-ideal solution to avoid such conflicts.

See:
- [A Narrative of Using Composer in a WordPress Plugin](https://wptavern.com/a-narrative-of-using-composer-in-a-wordpress-plugin)
- [A Warning About Using Composer With WordPress](https://blog.wppusher.com/a-warning-about-using-composer-with-wordpress/)

## Install

Installation should be done via composer, details of how to install composer can be found at [https://getcomposer.org/](https://getcomposer.org/).

First, add Imposter configuration in your `composer.json`

```json
"extra": {
    "imposter": {
        "namespace": "My\\App\\Vendor",
        "excludes": [
            "dummy/dummy-excluded"
        ]
    }
}
```

Then, install via composer cli

``` bash
$ composer require typisttech/imposter-plugin
```

See: [Imposter readme](https://github.com/Typisttech/imposter#config) for details.

## Usage

### Sit Back and Relax

Once installed, imposter plugin hooks into `composer install`, `composer update` and `composer dump-autoload`, automatically run [imposter](https://github.com/TypistTech/imposter/) for you.
Besides, imposter plugin autoloads all modified files as [classmap](https://getcomposer.org/doc/04-schema.md#classmap).

### composer imposter:run

If you want to run Imposter manually:
```bash
$ composer imposter:run
$ composer dump-autoload
```

**Note**: You need to run `$ composer dump-autoload` after every `$ composer imposter:run`.

This command:
1. Look for `/path/to/project/root/composer.json`
2. Find out [vendor-dir](https://getcomposer.org/doc/06-config.md#vendor-dir)
3. Find out all [required packages](https://getcomposer.org/doc/04-schema.md#require), including those required by dependencies
4. Find out all [autoload paths](https://getcomposer.org/doc/04-schema.md#autoload) for all required packages
5. Prefix all namespaces with the imposter-plugin namespace defined in your `composer.json`

Learn more on [imposter's readme](https://github.com/TypistTech/imposter#usage).

## Frequently Asked Questions

### What can I find more information?

Learn more on [imposter's readme](https://github.com/TypistTech/imposter/) for more details.

### How about not hooking into composer commands?

Use [imposter](https://github.com/TypistTech/imposter/) directly.

### Do you have real life examples that use this composer plugin?

Here you go:

 * [Sunny](https://github.com/Typisttech/sunny)
 * [WP Cloudflare Guard](https://github.com/TypistTech/wp-cloudflare-guard)


 *Add your own [here](https://github.com/TypistTech/imposter-plugin/edit/master/README.md)*

### Will you add support for older PHP versions?

Never! This package will only works on [actively supported PHP versions](https://secure.php.net/supported-versions.php).
Don't use it on **end of life** or **security fixes only** PHP versions.

### It looks awesome. Where can I find some more goodies like this?

* Articles on Typist Tech's [blog](https://typist.tech)
* [Tang Rufus' WordPress plugins](https://profiles.wordpress.org/tangrufus#content-plugins) on wp.org
* More projects on [Typist Tech's GitHub profile](https://github.com/TypistTech)
* Stay tuned on [Typist Tech's newsletter](https://typist.tech/go/newsletter)
* Follow [Tang Rufus' Twitter account](https://twitter.com/TangRufus)
* Hire [Tang Rufus](https://typist.tech/contact) to build your next awesome site

### This package isn't on wp.org. Where can I give a :star::star::star::star::star: review?

Thanks!

Consider writing a blog post, submitting pull requests, [sponsoring](https://typist.tech/donation/) or [hiring me](https://typist.tech/contact/) instead.

## Sponsoring :heart:

Love `imposter-plugin`? Help me maintain it, a [sponsorship here](https://typist.tech/donation/) can help with it.

### GitHub Sponsors Matching Fund

Do you know [GitHub is going to match your sponsorship](https://help.github.com/en/github/supporting-the-open-source-community-with-github-sponsors/about-github-sponsors#about-the-github-sponsors-matching-fund)?

[Sponsor now via GitHub](https://github.com/sponsors/TangRufus) to double your greatness.

### Why don't you hire me?

Ready to take freelance WordPress jobs. Contact me via the contact form [here](https://typist.tech/contact/) or, via email [info@typist.tech](mailto:info@typist.tech)

### Want to help in other way? Want to be a sponsor?

Contact: [Tang Rufus](mailto:tangrufus@gmail.com)

## Alternatives

Here is a list of alternatives that I found. But none satisfied my requirements.

*If you know other similar projects, feel free to edit this section!*

* [Mozart](https://github.com/coenjacobs/mozart) by Coen Jacobs
    - Works with PSR0 and PSR4
    - Dependency packages store in a different directory

* [PHP Scoper](https://github.com/humbug/php-scoper)
    - Prefixes all PHP namespaces in a file/directory to isolate the code bundled in PHARs

## Running the Tests

Run the tests:

``` bash
$ composer test
$ composer style:check
```

## Feedback

**Please provide feedback!** We want to make this library useful in as many projects as possible.
Please submit an [issue](https://github.com/TypistTech/imposter-plugin/issues/new) and point out what you do and don't like, or fork the project and make suggestions.
**No issue is too small.**

## Change log

Please see [CHANGELOG](./CHANGELOG.md) for more information on what has changed recently.

## Security

If you discover any security related issues, please email [imposter-plugin@typist.tech](mailto:imposter-plugin@typist.tech) instead of using the issue tracker.

## Credits

[`imposter-plugin`](https://github.com/TypistTech/imposter-plugin) is a [Typist Tech](https://typist.tech) project and maintained by [Tang Rufus](https://twitter.com/TangRufus), freelance developer for [hire](https://www.typist.tech/contact/).

Full list of contributors can be found [here](https://github.com/TypistTech/imposter-plugin/graphs/contributors).

## License

The MIT License (MIT). Please see [License File](./LICENSE) for more information.
