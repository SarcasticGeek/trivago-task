<?php

namespace App\Validator\Constraints;


use Doctrine\Instantiator\Exception\UnexpectedValueException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ItemNameValidator extends ConstraintValidator
{
    /**
     * @param mixed $value
     *
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ItemName) {
            throw new UnexpectedTypeException($constraint, ItemName::class);
        }

        if(!is_string($value) && strlen($value) > 10) {
            throw new UnexpectedValueException($value, 'string');
        }

        if(preg_match('/(Free|Offer|Book|Website|free|offer|book|website)/', $value)) {
            $this
                ->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }

}
