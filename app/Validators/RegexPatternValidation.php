<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class RegexPatternValidation extends AbstractValidator
{
    protected string $message = 'Значение поля :field не соответствует нужному формату.';

    public function rule(): bool
    {
        return (bool) preg_match($this->args[0], $this->value);
    }
}
