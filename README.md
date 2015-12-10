# axy\magic

Access to magic fields (PHP).

[![Latest Stable Version](https://img.shields.io/packagist/v/axy/magic.svg?style=flat-square)](https://packagist.org/packages/axy/magic)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.4-8892BF.svg?style=flat-square)](https://php.net/)
[![Build Status](https://img.shields.io/travis/axypro/magic/master.svg?style=flat-square)](https://travis-ci.org/axypro/magic)
[![Coverage Status](https://coveralls.io/repos/axypro/magic/badge.svg?branch=master&service=github)](https://coveralls.io/github/axypro/magic?branch=master)
[![License](https://poser.pugx.org/axy/magic/license)](LICENSE)

* The library does not require any dependencies (except composer packages).
* Tested on PHP 5.4+, PHP 7, HHVM (on Linux), PHP 5.5 (on Windows).
* Install: `composer require axy/magic`.
* License: [MIT](LICENSE).

### Documentation

The library provides several features for creating and accessing magic properties.

Most of the features made in the form of [Traits](http://php.net/traits).
So it can be implemented in classes at any level.
And they can be combined with each other.

* [ReadOnly](doc/ReadOnly.md) - the read-only container
* [ArrayMagic](doc/ArrayMagic.md) - access to fields as array elements
* [Named](doc/Named.md) - named objects
* [LazyField](doc/LazyField.md) - lazy fields
* [LazyContainer](doc/LazyContainer.md) - container with fixed set of lazy properties
* [ArrayWrapper](doc/ArrayWrapper.md) - wrapper over an array
* [List of errors](doc/errors.md)

The properties and methods defined by these Traits have the prefix `magic`.
