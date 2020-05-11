<?php

namespace vendor;

final class ValidationFactory
{
    /**
     * @param string $key
     * @return ValidationInterface|null
     */
    public function getValidation (string $key): ?ValidationInterface
    {
        switch ($key) {
            case NotEmptyValidation::NAME:
                return new NotEmptyValidation();
            case LengthValidation::NAME:
                return new LengthValidation();
            default:
                return null;
        }
    }
}
