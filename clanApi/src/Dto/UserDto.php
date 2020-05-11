<?php

namespace src\Dto;

class UserDto
{
    /** @var int  */
	private $id;

	/** @var string  */
	private $name;

	/** @var int  */
	private $rule;

    /**
     * @param array $data
     */
	public function __construct (array $data)
	{
		$this->id = $data['userId'] ?? null;
		$this->name = $data['userName'] ?? null;
		$this->rule = $data['userRule'] ?? null;
	}

    /**
     * @return int
     */
    public function getRule(): int
    {
        return $this->rule;
    }

    /**
     * @return array
     */
	public function toArray (): array
	{
		return [
			'id' => $this->id,
			'name' => $this->name,
			'rule' => $this->rule,
		];
	}
}