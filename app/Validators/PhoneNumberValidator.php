<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class PhoneNumberValidator extends AbstractValidator
{
    protected string $message = 'Поле :field не является номером телефона.';

    public function rule(): bool
    {
        $matches = preg_match('/^.[0-9]*$/', $this->value);

        return $matches === 1;
    }
}
