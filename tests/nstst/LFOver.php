<?php
/**
 * @package axy\magic
 */

namespace axy\magic\tests\nstst;

/**
 * @property-read string $over_field
 */
class LFOver extends LF
{
    public function __get($key)
    {
        if ($key === 'over_field') {
            return 'over_value';
        }
        return parent::__get($key);
    }

    public function __isset($key)
    {
        if ($key === 'over_field') {
            return true;
        }
        return parent::__isset($key);
    }
}
