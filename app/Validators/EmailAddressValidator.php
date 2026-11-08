<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class EmailAddressValidator extends AbstractValidator
{
    protected string $message = 'Поле :field не похоже на адрес электронной почты.';

    public function rule(): bool
    {
        $emailPattern = '/^.[0-9a-zA-Z.-]*@.[a-zA-Z]*\..[a-zA-Z]*$/';

        return (bool) preg_match($emailPattern, $this->value);
    }
}
