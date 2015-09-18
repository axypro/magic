# axy\magic: access to magic fields

* GitHub: [axypro/magic](https://github.com/axypro/magic)
* Composer: [axy/magic](https://packagist.org/packages/axy/magic)

PHP 5.4+

Library does not require any dependencies (except composer packages).

## Documentation

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
