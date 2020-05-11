<?php

namespace src\Dto;

class RequestDto
{
    /** @var int|null */
    private $userId;

    /** @var ClanRequestDto */
    private $clan;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->userId = $data['userId'] ?? null;
        $this->clan = new ClanRequestDto($data['clan'] ?? []);
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @return ClanRequestDto
     */
    public function getClan(): ?ClanRequestDto
    {
        return $this->clan;
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'userId' => $this->userId,
            'clan' => $this->clan->toArray(),
        ];
    }
}
