<?php
/**
 * @package axy\magic
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\magic\errors;

/**
 * Attempt to change the read-only object
 *
 * @link https://github.com/axypro/magic/blob/master/doc/errors.md documentation
 */
class ContainerReadOnly extends \axy\errors\ContainerReadOnly implements Error
{
}
