<?php

namespace src\UseCase;

use src\Dto\ClanDto;

class GetListClanUC extends AbstractClanUC
{
    /**
     * @return ClanDto[]
     */
	public function execute(): array
	{
		return $this->clanRepository->findAll();
	}
}