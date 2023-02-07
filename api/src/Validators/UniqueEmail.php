<?php

namespace App\Validators;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class UniqueEmail extends Constraint
{
    public string $message = 'Email already linked to existing account.';
}