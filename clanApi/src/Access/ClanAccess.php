<?php

namespace src\Access;

use src\Dto\RequestDto;
use src\UseCase\GetUserByIdUC;

class ClanAccess
{
    /** @var GetUserByIdUC */
    private $getUserById;

    public function __construct()
    {
        $this->getUserById = new GetUserByIdUC();
    }

    /**
     * @param RequestDto $dto
     * @param array $rules
     * @return bool
     */
    public function check(RequestDto $dto, array $rules): bool
    {
        $user = $this->getUserById->execute($dto);
        if (null === $user) {
            return false;
        }

        $userRule = $user->getRule();

        return  [] !== array_filter($rules, function (int $rule) use ($userRule): int {
                return $userRule & $rule;
        });
    }
}
