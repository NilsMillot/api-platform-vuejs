<?php

namespace App\Validators;

use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class UniqueEmailValidator extends ConstraintValidator
{
    public function __construct(private readonly UserRepository $userRepository){}

    public function validate($value, Constraint $constraint): void
    {
        $user = $this->userRepository->findOneBy(['email' => $value]);

        if ($user) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
