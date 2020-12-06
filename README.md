<div align="center">

# Imposter Plugin

</div>

<div align="center">


[![Packagist](https://img.shields.io/packagist/v/typisttech/imposter-plugin.svg?style=flat-square)](https://packagist.org/packages/typisttech/imposter-plugin)
[![Packagist](https://img.shields.io/packagist/dt/typisttech/imposter-plugin.svg?style=flat-square)](https://packagist.org/packages/typisttech/imposter-plugin)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/TypistTech/imposter-plugin?style=flat-square)](https://packagist.org/packages/typisttech/imposter-plugin)
[![CircleCI](https://img.shields.io/circleci/build/gh/TypistTech/imposter-plugin?style=flat-square)](https://circleci.com/gh/TypistTech/imposter-plugin)
[![license](https://img.shields.io/github/license/TypistTech/imposter-plugin.svg?style=flat-square)](https://github.com/TypistTech/imposter-plugin/blob/master/LICENSE)
[![Twitter Follow @TangRufus](https://img.shields.io/twitter/follow/TangRufus?style=flat-square&color=1da1f2&logo=twitter)](https://twitter.com/tangrufus)
[![Hire Typist Tech](https://img.shields.io/badge/Hire-Typist%20Tech-ff69b4.svg?style=flat-square)](https://www.typist.tech/contact/)

</div>

<p align="center">
  <strong>Composer plugin that wraps all composer vendor packages inside your own namespace. Intended for WordPress plugins.</strong>
  <br />
  <br />
  Built with ♥ by <a href="https://www.typist.tech/">Typist Tech</a>
</p>

---

**Imposter Plugin** is an open source project and completely free to use.

However, the amount of effort needed to maintain and develop new features is not sustainable without proper financial backing. If you have the capability, please consider donating using the links below:

<div align="center">

[![GitHub via Sponsor](https://img.shields.io/badge/Sponsor-GitHub-ea4aaa?style=flat-square&logo=github)](https://github.com/sponsors/TangRufus)
[![Sponsor via PayPal](https://img.shields.io/badge/Sponsor-PayPal-blue.svg?style=flat-square&logo=paypal)](https://typist.tech/go/paypal-donate/)
[![More Sponsorship Information](https://img.shields.io/badge/Sponsor-More%20Details-ff69b4?style=flat-square)](https://typist.tech/donate/imposter-plugin/)

</div>

---

Wrapping all composer vendor packages inside your own namespace. Intended for WordPress plugins. Imposter Plugin is a composer plugin wrapper for [Imposter](https://github.com/TypistTech/imposter/).

## Why?

Because of the lack of dependency management in WordPress, if two plugins bundled conflicting versions of the same package, hard-to-reproduce bugs arise.
Monkey patching composer vendor packages, wrapping them inside your own namespace is a less-than-ideal solution to avoid such conflicts.

See:
- [A Narrative of Using Composer in a WordPress Plugin](https://wptavern.com/a-narrative-of-using-composer-in-a-wordpress-plugin)
- [A Warning About Using Composer With WordPress](https://wppusher.com/blog/a-warning-about-using-composer-with-wordpress/)

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

```bash
composer require typisttech/imposter-plugin
```

See: [Imposter readme](https://github.com/Typisttech/imposter#config) for details.

---

<p align="center">
  <strong>Typist Tech is ready to build your next awesome WordPress site. <a href="https://typist.tech/contact/">Hire us!</a></strong>
</p>

---

## Usage

### Sit Back and Relax

Once installed, this plugin hooks into `composer install`, `composer update` and `composer dump-autoload`, automatically run [imposter](https://github.com/TypistTech/imposter/) for you.
Besides, imposter plugin autoloads all modified files as [classmap](https://getcomposer.org/doc/04-schema.md#classmap).

When those events triggered, this plugin:
1. looks for `/path/to/project/root/composer.json`
2. finds out [vendor-dir](https://getcomposer.org/doc/06-config.md#vendor-dir)
3. finds out all [required packages](https://getcomposer.org/doc/04-schema.md#require), including those required by dependencies
4. finds out all [autoload paths](https://getcomposer.org/doc/04-schema.md#autoload) for all required packages
5. prefixes all namespaces with the imposter-plugin namespace defined in your `composer.json`

Learn more on [imposter's readme](https://github.com/TypistTech/imposter#usage).

## Known Issues

Help wanted. Pull requests are welcomed.

1. Imposter run twice when `composer install` and `composer update`
1. Traits are not transformed
1. Virtual packages are not supported

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

### Which composer versions are supported?

Both v1 and v2.

### Will you add support for older PHP versions?

Never! This plugin will only work on [actively supported PHP versions](https://secure.php.net/supported-versions.php).

Don't use it on **end of life** or **security fixes only** PHP versions.

### It looks awesome. Where can I find some more goodies like this

- Articles on [Typist Tech's blog](https://typist.tech)
- [Tang Rufus' WordPress plugins](https://profiles.wordpress.org/tangrufus#content-plugins) on wp.org
- More projects on [Typist Tech's GitHub profile](https://github.com/TypistTech)
- Stay tuned on [Typist Tech's newsletter](https://typist.tech/go/newsletter)
- Follow [Tang Rufus' Twitter account](https://twitter.com/TangRufus)
- **Hire [Tang Rufus](https://typist.tech/contact) to build your next awesome site**

### Where can I give 5-star reviews?

Thanks! Glad you like it. It's important to let me knows somebody is using this project. Please consider:

- [tweet](https://twitter.com/intent/tweet?url=https%3A%2F%2Fgithub.com%2FTypistTech%2Fimposter-plugin&via=tangrufus&text=Imposter%20Plugin%20-%20Composer%20plugin%20that%20wraps%20all%20%23composer%20vendor%20packages%20inside%20your%20own%20namespace.%20Intended%20for%20%23WordPress%20plugins) something good with mentioning [@TangRufus](https://twitter.com/tangrufus)
- ★ star [the Github repo](https://github.com/TypistTech/imposter-plugin)
- [👀 watch](https://github.com/TypistTech/imposter-plugin/subscription) the Github repo
- write tutorials and blog posts
- **[hire](https://www.typist.tech/contact/) Typist Tech**

## Testing

```bash
composer test
composer style:check
```

## Alternatives

Here is a list of alternatives that I found. However, none of these satisfied my requirements.

*If you know other similar projects, feel free to edit this section!*

* [Mozart](https://github.com/coenjacobs/mozart) by Coen Jacobs
    - Works with PSR0 and PSR4
    - Dependency packages store in a different directory

* [PHP Scoper](https://github.com/humbug/php-scoper)
    - Prefixes all PHP namespaces in a file/directory to isolate the code bundled in PHARs

## Feedback

**Please provide feedback!** We want to make this project as useful as possible.
Please [submit an issue](https://github.com/TypistTech/imposter-plugin/issues/new) and point out what you do and don't like, or fork the project and [send pull requests](https://github.com/TypistTech/imposter-plugin/pulls/).
**No issue is too small.**

## Security Vulnerabilities

If you discover a security vulnerability within this project, please email us at [imposter-plugin@typist.tech](mailto:imposter-plugin@typist.tech).
All security vulnerabilities will be promptly addressed.

## Credits

[Imposter Plugin](https://github.com/TypistTech/imposter-plugin) is a [Typist Tech](https://typist.tech) project and maintained by [Tang Rufus](https://twitter.com/TangRufus), freelance developer for [hire](https://www.typist.tech/contact/).

Full list of contributors can be found [here](https://github.com/TypistTech/imposter-plugin/graphs/contributors).

## License

[Imposter Plugin](https://github.com/TypistTech/imposter-plugin) is released under the [MIT License](https://opensource.org/licenses/MIT).
