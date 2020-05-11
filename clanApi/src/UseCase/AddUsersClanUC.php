<?php

namespace src\UseCase;

use LogicException;
use src\Dto\RequestDto;

class AddUsersClanUC extends AbstractClanUC
{
    /**
     * @param RequestDto $dto
     */
    public function execute(RequestDto $dto): void
    {
        if (true === $this->clanRepository->addUsers($dto->getClan())) {
            return;
        }

        throw new LogicException();
    }
}
