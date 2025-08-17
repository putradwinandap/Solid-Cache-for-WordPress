<?php

namespace PtrSoc\Interfaces\WordPress\Ajax;

use PtrSoc\Domain\Contracts\AjaxHandler;

abstract class AbstractAjaxHandler implements AjaxHandler
{
    abstract public function action(): string;

    abstract public function callback();

    public function nonceAction(): string
    {
        return 'ptrsoc_nonce';
    }

    public function capability(): ?string
    {
        return 'manage_options'; // batasi ke admin
    }
}
