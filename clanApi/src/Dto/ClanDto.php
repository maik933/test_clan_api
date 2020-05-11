<?php

namespace src\Dto;

class ClanDto
{
    /** @var int|null  */
	private $id;

    /** @var string|null  */
	private $name;

    /** @var string|null  */
	private $description;

    /** @var int[]  */
	private $users;

    /**
     * @param array $data
     */
	public function __construct (array $data)
	{
		$this->id = $data['id'] ?? null;
		$this->name = $data['name'] ?? null;
		$this->description = $data['description'] ?? null;
		$this->addUser(new UserDto($data));
		
	}

    /**
     * @param UserDto $user
     */
	public function addUser (UserDto $user)
	{
		$this->users[] = $user;
	}

    /**
     * @return array
     */
	public function toArray(): array
	{
		return [
			'id' => $this->id,
			'name' => $this->name,
			'description' => $this->description,
			'users' => array_map(function (UserDto $dto): array {
				return $dto->toArray();
			}, $this->users)
		];
	}
}