<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CheckboxRequiredValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        /** @var App\Validator\CheckboxRequired $constraint */
        if (count($value) > 0) {
            return;
        }

        // TODO: implement the validation here
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
