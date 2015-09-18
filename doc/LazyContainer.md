# `LazyContainer`

A simplified version of [LazyFields](./LazyField.md).
A container contains a fixed set of the properties.
A property is created when the first call.
A property is created by method `<propertyName>PropCreate()`.

```php
/**
 * @property-read One $one
 * @property-read Two $two
 */
class MyContainer extends LazyContainer
{
    protected function onePropCreate()
    {
        return new One(1);
    }

    protected function twoPropCreate()
    {
        return new Two(2);
    }
}

$c = new MyContainer();

echo $c->one; // One(1)
echo $c->two; // Two(1)
isset($c->one); // True
isset($c->two); // True
isset($c->three); // False
($c->one === $c->one); // A property creates once
echo $c->three; // Exception axy\magic\errors\FieldNotExist
```

ArrayAccess is implemented:

```php
echo $c['one'];
isset($c['two']);
```

The container is read-only:

```php
$c->one = 1; // Exception axy\magic\errors\ContainerReadOnly
```

## `propCreate()`

If a method-builder does not exist then call `propCreate($key)`.
By default this method throws `FieldNotExists` but you can override it.

```php
/**
 * @property-read One $one
 * @property-read Two $two
 * @property-read Three $three
 */
class MyContainer extends LazyContainer
{
    // ...

    protected function propCreate($key)
    {
        if ($key === 'three') {
            return new Three();
        }
        return parent::propCreate(); // exception for other properties
    }
}
```

## `isset`

`isset($c->one)` for the example-class does not create the property.
Just looking for a method `onePropCreate`.

`isset($c->three)` creates the property as it requires call `propCreate`.