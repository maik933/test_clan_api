<?php

namespace src\UseCase;

use src\Dto\RequestDto;
use LogicException;

class DownUserToSoldierUC extends AbstractClanUC
{
    /**
     * @param RequestDto $dto
     */
    public function execute(RequestDto $dto): void
    {
        if(true === $this->clanRepository->downUserToSoldier($dto->getClan())) {
            return;
        }

        throw new LogicException();
    }
}