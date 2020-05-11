<?php

namespace src\UseCase;

use LogicException;
use src\Dto\RequestDto;

class UpdateClanDescriptionUC extends AbstractClanUC
{

    /**
     * @param RequestDto $dto
     */
    public function execute(RequestDto $dto): void
    {
        if (true === $this->clanRepository->updateDescription($dto->getClan())) {
            return;
        }

        throw new LogicException();
    }
}
