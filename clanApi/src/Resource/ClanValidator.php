<?php

namespace src\Resource;

use vendor\LengthValidation;
use vendor\NotEmptyValidation;
use vendor\ValidatorInterface;

class ClanValidator implements ValidatorInterface
{
    /**
     * @inheritDoc
     */
    public function getPrecept(): array
    {
        return [
            'userId' => [
                NotEmptyValidation::NAME => [
                    'groups' => ['updateDescription', 'create', 'updateUsers', 'updateRule', 'delete'],
                    'message' => 'userId is empty'
                ],
            ],
            'clan.id' => [
                NotEmptyValidation::NAME => [
                    'groups' => ['updateDescription', 'updateUsers', 'updateRule', 'delete'],
                    'message' => 'Clan id is empty'
                ],
            ],
            'clan.name' => [
                NotEmptyValidation::NAME => [
                    'groups' => ['create'],
                    'message' => 'Clan name is empty'
                ],
                LengthValidation::NAME => [
                    'groups' => ['create'],
                    'max' => 12,
                    'message' => 'Clan name is long(max 12)'
                ],
            ],
            'clan.description' => [
                NotEmptyValidation::NAME => [
                    'groups' => ['updateDescription', 'create'],
                    'message' => 'Clan description is empty'
                ],
                LengthValidation::NAME => [
                    'groups' => ['updateDescription', 'create'],
                    'max' => 30,
                    'message' => 'Clan description is long(max 30)'
                ],
            ],
            'clan.users' => [
                NotEmptyValidation::NAME => [
                    'groups' => ['create', 'updateUsers'],
                    'message' => 'Clan users is empty'
                ],
            ],
        ];
    }
}
