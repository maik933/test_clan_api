<?php

namespace vendor;

interface ValidationInterface
{
    /**
     * @param $value
     * @param array $option
     * @param string|null $group
     * @return string|null
     */
    public function execute($value, array $option = [], ?string $group = null): ?string;
}
