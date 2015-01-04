# `ArrayWrapper`

An instance of the `ArrayWrapper` class is the wrapper over an associative array.

## The constructor

```php
__construct([array $source [, boolean $readonly [, boolean $errProp])
```

* `$source` - the initial value of the internal array.
* `$readonly` and `$errProp` - see below.

```php
$a1 = new ArrayWrapper(['x' => 1]);
$a2 = new ArrayWrapper(); // wrapper over the empty (yet) array
```

## Magic

Magic fields:

```php
$a = new ArrayWrapper(['x' => 1]);
echo $a->x; // 1
echo $a->y; // null
if (!isset($a->y)) {
    $a->y = 2;
    unset($a->x);
}
```

And `ArrayAccess`:

```php
$a->x = 1;
echo $a['x']; // 1
```

Also implemented `Countable` and `IteratorAggregate`.

## `getSource(void):array`

Returns the internal array.

## `$source`

This protected property contains the internal array.
With it, you can also set the initial value for the array. 
In this case, an array from constructor will merge with the initial value.

```php
class MyWrapper extends ArrayWrapper
{
    protected $source = [
        'one' => 'First,
        'two' => 'Second',
    ];
}

$a = new MyWrapper([
    'two' => 'New value for two',
    'three' => 'Third',
]);

echo $a->one; // First
echo $a->two; // New value for two
echo $a->three; // Third
```

## Read-only mode

If the second argument of the constructor set to `TRUE` then the array cannot be changed from the outside.

```php
$a = new ArrayWrapper(['x' => 1], true);
echo $a->x; // 1
$a->x = 2; // throw ContainerReadOnly
```

Or, you can pre-fill the array and then switch it to read-only mode.

```php
$a = new ArrayWrapper();
$a->x = 1;
$a->y = 2;
$a->toReadonly();
```

Method `isReadonly(void):boolean` can be used to check the mode of the wrapper.

The protected property `$readonly` contains the mode flag.
Can make an inherited class readonly by default:

```php
class MyWrapper extends ArrayWrapper
{
    protected $readonly = true;
}

$a = new MyWrapper();
$a->x = 1; // ContainerReadOnly
```

## To throw an exception for non-existent fields

When you read a non-existent property returns `NULL` (by default).
If the third argument of the constructor set to `TRUE` then the exception will be thrown.

```php
$a = new ArrayWrapper(['x' => 1], null, true);

echo $a->x; // 1
$a->y = 2; // nonexistent value can be set
echo $a->y; // 2
echo $a->z; // throw FieldNotExists
```

You can make this the default behavior for an inherited class:
```php
class MyWrapper extends ArrayWrapper
{
    protected $errProp = true;
}
```

## Fixed array structure

```php
class Options extends ArrayWrapper
{
    protected $source = [
        'max_time_limit' => 30,
        'max_post_size' => 1024,
        'display_errors' => false,
    ];

    protected $readonly = true;
    protected $errProp = true;
    protected $fixed = true;
}

$options1 = new Options(['display_errors' => true]);

$options2 = new Options(['custom_option' => 10]); // throw FieldNotExists
```

If the protected property `$fixed` set to `TRUE` the the array structure is considered fixed.
The initial value of `$source` defines this structure and default values for fields.

You cannot add new fields by the magic methods or by the constructor.
