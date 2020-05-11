<?php

namespace src\UseCase;

use LogicException;
use src\Dto\RequestDto;

class DeleteUsersClanUC extends AbstractClanUC
{
    /**
     * @param RequestDto $dto
     */
    public function execute(RequestDto $dto): void
    {
        if (true === $this->clanRepository->deleteUsers($dto->getClan())) {
            return;
        }

        throw new LogicException();
    }
}
