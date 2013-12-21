<?php
/**
 * @package axy\magic
 */

namespace axy\magic\tests\nstst;

class AAMagicConvert extends AAMagic
{
    /**
     * {@inheritdoc}
     */
    protected function convertArrayKeyToMagic($key)
    {
        return \str_replace('-', '_', $key);
    }
}
