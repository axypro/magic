<?php
/**
 * @package axy\magic
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\magic\errors;

/**
 * A field does not exist in a fixed list of the container
 *
 * @link https://github.com/axypro/magic/blob/master/doc/errors.md documentation
 */
class FieldNotExist extends \axy\errors\FieldNotExist implements Error
{
}
