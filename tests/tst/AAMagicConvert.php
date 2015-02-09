<?php
/**
 * @package axy\magic
 */

namespace axy\magic\tests\tst;

class AAMagicConvert extends AAMagic
{
    /**
     * {@inheritdoc}
     */
    protected function magicConvertIndexToKey($key)
    {
        return str_replace('-', '_', $key);
    }
}
