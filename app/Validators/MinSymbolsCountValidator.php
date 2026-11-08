<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class MinSymbolsCountValidator extends AbstractValidator
{
    protected string $message = 'Поле :field слишком короткое: нужно хотя бы :min символов.';

    public function rule(): bool
    {
        $limit = (int) $this->args[0];

        return (bool) (strlen($this->value) >= $limit);
    }
}
