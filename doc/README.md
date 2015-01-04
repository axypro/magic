# `axy\magic`: access to magic fields

The library provides several features for creating and accessing magic properties.

Most of the features made in the form of [Traits](http://php.net/traits).
So it can be implemented in classes at any level.
And they can be combined with each other.

* [ReadOnly](ReadOnly.md) - the read-only container
* [ArrayMagic](ArrayMagic.md) - access to fields as array elements
* [Named](Named.md) - named objects
* [LazyField](LazyField.md) - lazy build of fields
* [ArrayWrapper](ArrayWrapper.md) - wrapper over an array
* [List of errors](errors.md) 

Most of the properties and methods defined by these Traits have the prefix `magic`.
