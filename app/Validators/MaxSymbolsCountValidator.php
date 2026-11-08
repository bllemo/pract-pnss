<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class MaxSymbolsCountValidator extends AbstractValidator
{
    protected string $message = 'Поле :field длиннее, чем можно: максимум :max символов.';

    public function rule(): bool
    {
        $limit = (int) $this->args[0];

        return (bool) (strlen($this->value) <= $limit);
    }
}
