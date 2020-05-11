<?php

namespace src\UseCase;

use src\Dto\RequestDto;
use src\Dto\UserDto;
use src\Repository\UserRepository;

class GetUserByIdUC
{
    /** @var UserRepository  */
	private $userRepository;
	
	public function __construct ()
	{
		$this->userRepository = new UserRepository();
	}

    /**
     * @param RequestDto $dto
     * @return UserDto|null
     */
	public function execute(RequestDto $dto): ?UserDto
	{
		return $this->userRepository->findById($dto);
	}
}
