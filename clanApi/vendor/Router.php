<?php

namespace vendor;

class Router
{
    /**
     * @var array
     */
	private $routes = [];

    /**
     * @param array $routes
     */
	public function __construct (array $routes)
	{
		foreach($routes as $route) {
			$this->routes[array_shift($route)] = new Route($route);
		}
	}
	
	public function run (): void
	{
		$route = $this->getRoute();
		if (null === $route) {
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(Response::HTTP_NOT_FOUND);

            echo json_encode([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => Response::MESSAGES[Response::HTTP_NOT_FOUND],
            ]);

			return;
		}
		
		$controllerClass = $this->getControllerClass($route);
		$controller = new $controllerClass;
		
		$controllerAction = $route->getAction();
		$controller->$controllerAction();
		
	}

    /**
     * @param Route $route
     * @return string
     */
	private function getControllerClass(Route $route): string
	{
		return sprintf('src\Controller\%s', $route->getController());
	}

    /**
     * @return Route|null
     */
	private function getRoute(): ?Route
	{
		return $this->routes[sprintf('%s %s', $_SERVER['REQUEST_METHOD'], $_GET['route'] ?? '')] ?? null;
	}
}