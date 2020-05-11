<?php

namespace src\UseCase;

use src\Dto\RequestDto;
use LogicException;

class SaveClanUC extends AbstractClanUC
{
    /**
     * @param RequestDto $dto
     */
    public function execute(RequestDto $dto): void
    {
        if(true === $this->clanRepository->save($dto)) {
            return;
        }

        throw new LogicException();
    }
}