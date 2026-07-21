<?php

namespace Requests;

abstract class BaseRequest
{
    abstract function validate(): array;

    protected function sanitize(string $value): string
    {
        return trim(strip_tags($value));
    }
}