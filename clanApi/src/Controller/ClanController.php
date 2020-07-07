<?php

namespace src\Controller;

use src\Access\ClanAccess;
use src\Resource\ClanValidator;
use src\Rule\Rule;
use src\Transformer\RequestTransformer;
use src\UseCase\AddUsersClanUC;
use src\UseCase\DeleteClanUC;
use src\UseCase\DeleteUsersClanUC;
use src\UseCase\DownUserToSoldierUC;
use src\UseCase\SaveClanUC;
use src\UseCase\UpdateClanDescriptionUC;
use src\UseCase\UpUserToDeputyUC;
use vendor\AbstractController;
use src\Dto\ClanDto;
use src\UseCase\GetListClanUC;
use src\Transformer\ClanTransformer;
use LogicException;
use vendor\Validator;

class ClanController extends AbstractController
{
    private const VALIDATION_GROUP_CREATE = 'create';
    private const VALIDATION_GROUP_UPDATE_USERS = 'updateUsers';
    private const VALIDATION_GROUP_UPDATE_RULE = 'updateRule';
    private const VALIDATION_GROUP_DELETE = 'delete';
    private const VALIDATION_GROUP_UPDATE_DESCRIPTION = 'updateDescription';

    /** @var GetListClanUC  */
	private $getListClanUC;

	/** @var ClanTransformer  */
	private $clanTransformer;

	/** @var SaveClanUC  */
	private $saveClanUC;

	/** @var UpdateClanDescriptionUC */
	private $updateClanDescriptionUC;

	/** @var ClanAccess */
	private $clanAccess;

	/** @var Validator */
	private $validator;

	/** @var DeleteClanUC */
	private $deleteClanUC;

    /** @var DeleteUsersClanUC */
	private $deleteUsersClanUC;

	/** @var AddUsersClanUC */
	private $addUsersClanUC;

	/** @var UpUserToDeputyUC */
	private $upUserToDeputyUC;

	/** @var DownUserToSoldierUC */
	private $downUserToSoldierUC;
	
	public function __construct ()
	{
		$this->getListClanUC = new GetListClanUC();
		$this->clanTransformer = new ClanTransformer();
        $this->saveClanUC = new SaveClanUC();
        $this->updateClanDescriptionUC = new UpdateClanDescriptionUC();
        $this->clanAccess = new ClanAccess();
        $this->validator = new Validator();
        $this->deleteClanUC = new DeleteClanUC();
        $this->deleteUsersClanUC = new DeleteUsersClanUC();
        $this->addUsersClanUC = new AddUsersClanUC();
        $this->upUserToDeputyUC = new UpUserToDeputyUC();
        $this->downUserToSoldierUC = new DownUserToSoldierUC();
		
		parent::__construct();
	}

	public function getList (): void
	{
		$this->response200(array_map(function (ClanDto $dto): array {
			return $dto->toArray();
		}, $this->getListClanUC->execute()));
	}
	
	public function create (): void
	{
        $dto = $this->clanTransformer->transformToRequestDto();

        $errors = $this->validator->execute(new ClanValidator(), $dto->toArray(), self::VALIDATION_GROUP_CREATE);
        if([] !== $errors) {
            $this->response422($errors);

            return;
        }

	    try {
            $this->saveClanUC->execute($dto);
        } catch (LogicException $exception) {
            $this->response422();

            return;
        }

		$this->response201();
	}

	public function updateDescription (): void
    {
        $dto = $this->clanTransformer->transformToRequestDto();

        $errors = $this->validator->execute(new ClanValidator(), $dto->toArray(), self::VALIDATION_GROUP_UPDATE_DESCRIPTION);
        if([] !== $errors) {
            $this->response422($errors);

            return;
        }

        if (false === $this->clanAccess->check($dto, [Rule::DEPUTY, Rule::LEADER])) {
            $this->response403();

            return;
        }

        try {
            $this->updateClanDescriptionUC->execute($dto);
        } catch (LogicException $exception) {
            $this->response422();

            return;
        }

        $this->response200();
    }

    public function delete (): void
    {
        $dto = $this->clanTransformer->transformToRequestDto();

        $errors = $this->validator->execute(new ClanValidator(), $dto->toArray(), self::VALIDATION_GROUP_DELETE);
        if([] !== $errors) {
            $this->response422($errors);

            return;
        }

        if (false === $this->clanAccess->check($dto, [Rule::LEADER])) {
            $this->response403();

            return;
        }

        try {
            $this->deleteClanUC->execute($dto);
        } catch (LogicException $exception) {
            $this->response422();

            return;
        }

        $this->response200();
    }

    public function deleteUsers (): void
    {
        $dto = $this->clanTransformer->transformToRequestDto();

        $errors = $this->validator->execute(new ClanValidator(), $dto->toArray(), self::VALIDATION_GROUP_UPDATE_USERS);
        if([] !== $errors) {
            $this->response422($errors);

            return;
        }

        if (false === $this->clanAccess->check($dto, [Rule::LEADER])) {
            $this->response403();

            return;
        }

        try {
            $this->deleteUsersClanUC->execute($dto);
        } catch (LogicException $exception) {
            $this->response422();

            return;
        }

        $this->response200();
    }

    public function addUsers (): void
    {
        $dto = $this->clanTransformer->transformToRequestDto();

        $errors = $this->validator->execute(new ClanValidator(), $dto->toArray(), self::VALIDATION_GROUP_UPDATE_USERS);
        if([] !== $errors) {
            $this->response422($errors);

            return;
        }

        if (false === $this->clanAccess->check($dto, [Rule::LEADER])) {
            $this->response403();

            return;
        }

        try {
            $this->addUsersClanUC->execute($dto);
        } catch (LogicException $exception) {
            $this->response422();

            return;
        }

        $this->response200();
    }

    public function upDeputy ()
    {
        $dto = $this->clanTransformer->transformToRequestDto();

        $errors = $this->validator->execute(new ClanValidator(), $dto->toArray(), self::VALIDATION_GROUP_UPDATE_RULE);
        if([] !== $errors) {
            $this->response422($errors);

            return;
        }

        if (false === $this->clanAccess->check($dto, [Rule::DEPUTY, Rule::LEADER])) {
            $this->response403();

            return;
        }

        try {
            $this->upUserToDeputyUC->execute($dto);
        } catch (LogicException $exception) {
            $this->response422();

            return;
        }

        $this->response200();
    }

    public function downDeputy ()
    {
        $dto = $this->clanTransformer->transformToRequestDto();

        $errors = $this->validator->execute(new ClanValidator(), $dto->toArray(), self::VALIDATION_GROUP_UPDATE_RULE);
        if([] !== $errors) {
            $this->response422($errors);

            return;
        }

        if (false === $this->clanAccess->check($dto, [Rule::LEADER])) {
            $this->response403();

            return;
        }

        try {
            $this->downUserToSoldierUC->execute($dto);
        } catch (LogicException $exception) {
            $this->response422();

            return;
        }

        $this->response200();
    }

    public function getList (): void
    {
        $this->response200(array_map(function (ClanDto $dto): array {
            return $dto->toArray();
        }, $this->getListClanUC->execute()));
        //code-branch02
        //new-branch-3
        //b-4
    }
}
