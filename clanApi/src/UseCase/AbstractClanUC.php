<?php

namespace src\UseCase;

use src\Repository\ClanRepository;

abstract class AbstractClanUC
{
    /** @var ClanRepository  */
	protected $clanRepository;
	
	public function __construct ()
	{
		$this->clanRepository = new ClanRepository();
	}
}