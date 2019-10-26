<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class ItemName
 * @package App\Validator\Constraints
 * @Annotation
 */
class ItemName extends Constraint
{
    public $message = 'The Item Name "{{ string }}" contains an invalid Chars.';

}
