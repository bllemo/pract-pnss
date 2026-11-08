<?php

namespace Validators;

use Illuminate\Database\Capsule\Manager as Capsule;
use Src\Validator\AbstractValidator;

class UniqueFieldValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно быть уникальным.';

    public function rule(): bool
    {
        [$table, $column] = $this->args;

        $alreadyExists = Capsule::table($table)
            ->where($column, $this->value)
            ->count();

        return !$alreadyExists;
    }
}
