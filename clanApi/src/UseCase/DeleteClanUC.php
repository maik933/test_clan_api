<?php

namespace src\UseCase;

use LogicException;
use src\Dto\RequestDto;

class DeleteClanUC extends AbstractClanUC
{
    /**
     * @param RequestDto $dto
     */
    public function execute(RequestDto $dto): void
    {
        if (true === $this->clanRepository->delete($dto->getClan())) {
            return;
        }

        throw new LogicException();
    }
}
