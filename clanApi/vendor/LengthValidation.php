<?php

namespace vendor;

class LengthValidation implements ValidationInterface
{
    public const NAME = 'length';

    /**
     * @inheritDoc
     */
    public function execute($value, array $option = [], ?string $group = null): ?string
    {

        if (false === in_array($group, $option['groups'], true)) {
            return null;
        }

        return mb_strlen($value) > $option['max'] ? $option['message'] : null;
    }
}
