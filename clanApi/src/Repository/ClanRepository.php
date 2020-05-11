<?php

namespace src\Repository;

use src\Dto\ClanRequestDto;
use src\Dto\RequestDto;
use src\Rule\Rule;
use vendor\Database;
use src\Dto\ClanDto;
use src\Dto\UserDto;
use mysqli;

class ClanRepository
{
    /** @var mysqli  */
	private $conn;
	
	public function __construct ()
	{
		$this->conn = (new Database())->getConnection();
	}

    /**
     * @return ClanDto[]
     */
	public function findAll()
	{
		$result = $this->conn->query(
			"SELECT 
				c.*,
				u.id userId,
				u.name userName,
				cu.rule userRule 
			FROM clans c
			JOIN clan_users cu ON c.id=cu.clan_id
			JOIN users u ON u.id=cu.user_id"
		);
		
		$clans = [];
		while($row = $result->fetch_assoc()) {
			$id = $row['id'];
			$clan = $clans[$id] ?? null;
			if (null === $clan) {
				$clans[$id] = new ClanDto($row);
				
				continue;
			}
			
			$clan->addUser(new UserDto($row));
		}
		
		return $clans;
	}

    /**
     * @param RequestDto $dto
     * @return bool
     */
	public function save(RequestDto $dto): bool
    {
        $this->conn->begin_transaction();

        $clan = $dto->getClan();
        $name = $clan->getName();
        $description = $clan->getDescription();

        $prepare = $this->conn->prepare("INSERT INTO clans SET name=?, description=?");
        $prepare->bind_param('ss', $name, $description);
        $prepare->execute();

        if($prepare->error) {
            return false;
        }

        $clanId = $prepare->insert_id;
        $users = $clan->getUsers();
        $query = "INSERT INTO clan_users (clan_id, user_id, rule) VALUES (?,?,?),";
        foreach ($users as $user) {
            $query .= sprintf(' (%d,%d,%d),', $clanId, $user, Rule::SOLDIER);
        }

        $user = $dto->getUserId();
        $rule = Rule::LEADER;

        $prepare = $this->conn->prepare(substr($query, 0, -1));
        $prepare->bind_param('iii', $clanId,$user, $rule);

        $prepare->execute();

        if($prepare->error) {
            return false;
        }

        $this->conn->commit();

        return true;
    }

    /**
     * @param ClanRequestDto $dto
     * @return bool
     */
    public function updateDescription (ClanRequestDto $dto): bool
    {
        $description = $dto->getDescription();
        $id = $dto->getId();

        $prepare = $this->conn->prepare("UPDATE clans SET description=? WHERE id=?");
        $prepare->bind_param('si', $description,$id);
        $prepare->execute();

        return $prepare->error ? false : true;
    }

    /**
     * @param ClanRequestDto $dto
     * @return bool
     */
    public function delete (ClanRequestDto $dto): bool
    {
        $id = $dto->getId();

        $prepare = $this->conn->prepare("DELETE FROM clans WHERE id=?");
        $prepare->bind_param('i', $id);
        $prepare->execute();

        return $prepare->error ? false : true;
    }

    /**
     * @param ClanRequestDto $dto
     * @return bool
     */
    public function deleteUsers (ClanRequestDto $dto): bool
    {
        $query = sprintf("DELETE FROM clan_users WHERE rule=%d AND user_id IN (", Rule::SOLDIER);

        $users = $dto->getUsers();
        foreach ($users as $user) {
            $query .= sprintf('%d,', $user);
        }

        return false !== $this->conn->query(sprintf('%s)',substr($query, 0, -1)));
    }

    /**
     * @param ClanRequestDto $dto
     * @return bool
     */
    public function addUsers (ClanRequestDto $dto): bool
    {
        $query = "INSERT INTO clan_users (clan_id, user_id, rule) VALUES ";

        $users = $dto->getUsers();
        foreach ($users as $user) {
            $query .= sprintf(' (%d,%d,%d),', $dto->getId(), $user, Rule::SOLDIER);
        }

        return false !== $this->conn->query(substr($query, 0, -1));
    }

    /**
     * @param ClanRequestDto $dto
     * @return bool
     */
    public function upUserToDeputy (ClanRequestDto $dto): bool
    {
        return $this->updateUserRule(
            $dto,
            sprintf(
                "UPDATE clan_users SET rule=rule | %d WHERE clan_id=%d AND user_id IN (",
                RUle::DEPUTY,
                $dto->getId()
            )
        );
    }

    /**
     * @param ClanRequestDto $dto
     * @return bool
     */
    public function downUserToSoldier (ClanRequestDto $dto): bool
    {
        return $this->updateUserRule(
            $dto,
            sprintf("UPDATE clan_users SET rule=rule &~ %d WHERE clan_id=%d AND user_id IN (",
                RUle::DEPUTY,
                $dto->getId()
            )
        );
    }

    /**
     * @param ClanRequestDto $dto
     * @param string $query
     * @return bool
     */
    private function updateUserRule(ClanRequestDto $dto, string $query): bool
    {
        $users = $dto->getUsers();
        foreach ($users as $user) {
            $query .= sprintf('%d,', $user);
        }

        return false !== $this->conn->query(sprintf('%s)',substr($query, 0, -1)));
    }
}
