<?php

namespace vendor;

class NotEmptyValidation implements ValidationInterface
{
    public const NAME = 'notEmpty';

    /**
     * @inheritDoc
     */
    public function execute($value, array $option = [], ?string $group = null): ?string
    {

        if (false === in_array($group, $option['groups'], true)) {
            return null;
        }

        return null === $value ? $option['message'] : null;
    }
}
