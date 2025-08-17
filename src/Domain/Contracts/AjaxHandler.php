<?php
namespace PtrSoc\Domain\Contracts;

interface AjaxHandler {
    public function action(): string;
    public function nonceAction(): string;
    public function capability(): ?string;
    public function callback();
}