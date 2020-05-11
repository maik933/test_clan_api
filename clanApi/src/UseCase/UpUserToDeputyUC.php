<?php

namespace src\UseCase;

use src\Dto\RequestDto;
use LogicException;

class UpUserToDeputyUC extends AbstractClanUC
{
    /**
     * @param RequestDto $dto
     */
    public function execute(RequestDto $dto): void
    {
        if(true === $this->clanRepository->upUserToDeputy($dto->getClan())) {
            return;
        }

        throw new LogicException();
    }
}