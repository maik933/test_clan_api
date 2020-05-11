<?php

namespace vendor;

class Response
{
	public const HTTP_OK = 200;
    public const HTTP_CREATED = 201;
    public const HTTP_FORBIDDEN = 403;
    public const HTTP_NOT_FOUND = 404;
    public const HTTP_UNPROCESSABLE_ENTITY = 422;

	public const HTTP_OK_MESSAGE = 'Ok';
    public const HTTP_CREATED_MESSAGE = 'Created';
    public const HTTP_FORBIDDEN_MESSAGE = 'Forbidden';
    public const HTTP_NOT_FOUND_MESSAGE = 'Not Found';
    public const HTTP_UNPROCESSABLE_ENTITY_MESSAGE = 'Unprocessable Entity';

	public const MESSAGES = [
	    self::HTTP_OK => self::HTTP_OK_MESSAGE,
        self::HTTP_CREATED => self::HTTP_CREATED_MESSAGE,
        self::HTTP_FORBIDDEN => self::HTTP_FORBIDDEN_MESSAGE,
        self::HTTP_NOT_FOUND => self::HTTP_NOT_FOUND_MESSAGE,
        self::HTTP_UNPROCESSABLE_ENTITY => self::HTTP_UNPROCESSABLE_ENTITY_MESSAGE,
    ];
}