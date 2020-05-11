<?php

namespace src\Transformer;

use src\Dto\RequestDto;

class ClanTransformer
{
    /** @var array */
    private $data;

    public function __construct()
    {
        $this->data = json_decode(file_get_contents('php://input'), true);
    }

    /**
     * @return RequestDto
     */
	public function transformToRequestDto (): RequestDto
	{
		return new RequestDto($this->data);
	}
}