<?php
/**
 * @package axy\magic
 */

namespace axy\magic\errors;

/**
 * Attempt to change the read-only object
 *
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */
class ContainerReadOnly extends \axy\errors\ContainerReadOnly implements Error
{
}
