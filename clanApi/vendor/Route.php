<?php

namespace vendor;

class Route
{
	/** var string */
	private $controller;
	
	/** var string */
	private $action;

    /**
     * @param array $route
     */
	public function __construct (array $route)
	{
		[$this->controller, $this->action] = $route;
	}

    /**
     * @return string
     */
	public function getController(): string
	{
		return $this->controller;
	}

    /**
     * @return string
     */
	public function getAction(): string
	{
		return $this->action;
	}
}