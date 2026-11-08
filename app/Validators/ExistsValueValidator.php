<?php

namespace Validators;

use Illuminate\Database\Capsule\Manager as Capsule;
use Src\Validator\AbstractValidator;

class ExistsValueValidator extends AbstractValidator
{
    protected string $message = 'Значение поля :field должно существовать.';

    public function rule(): bool
    {
        [$table, $column] = $this->args;

        $rows = Capsule::table($table)
            ->where($column, $this->value)
            ->count();

        return (bool) $rows;
    }
}
