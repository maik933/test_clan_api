<?php

namespace src\Repository;

use src\Dto\RequestDto;
use vendor\Database;
use src\Dto\UserDto;
use mysqli;

class UserRepository
{
    /** @var mysqli  */
	private $conn;
	
	public function __construct ()
	{
		$this->conn = (new Database())->getConnection();
	}

    /**
     * @param RequestDto $dto
     * @return UserDto|null
     */
	public function findById(RequestDto $dto): ?UserDto
	{
        $prepare = $this->conn->prepare(
			"SELECT 
				u.id userId,
				u.name userName,
				cu.rule userRule
			FROM users u
			JOIN clan_users cu ON u.id=cu.user_id
			WHERE u.id=? AND cu.clan_id=?"
		);

        $userId = $dto->getUserId();
        $clanId = $dto->getClan()->getId();

        $prepare->bind_param('ii', $userId, $clanId);
        $prepare->execute();

        if ($prepare->error) {
            return null;
        }

        $user = $prepare->get_result()->fetch_assoc();
        if (null === $user) {
            return null;
        }

        return new UserDto($user);
	}
}