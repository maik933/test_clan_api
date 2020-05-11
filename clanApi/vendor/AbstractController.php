<?php

namespace vendor;

abstract class AbstractController
{
	public function __construct ()
	{
		header("Content-Type: application/json; charset=UTF-8");
	}

    /**
     * @param array $data
     */
	protected function response200 (array $data = []): void
	{
		http_response_code(Response::HTTP_OK);

		echo json_encode($data);
	}

    protected function response201 (): void
    {
        $this->response(Response::HTTP_CREATED);
    }

    protected function response403 (): void
    {
        $this->response(Response::HTTP_FORBIDDEN);
    }

    /**
     * @param array|null $message
     */
    protected function response422 (?array $message = null): void
    {
        $this->response(Response::HTTP_UNPROCESSABLE_ENTITY, $message);
    }

    /**
     * @param int $code
     * @param array|null $message
     */
    private function response(int $code, ?array $message = null): void
    {
       http_response_code($code);

        echo json_encode([
            'status' => $code,
            'message' => $message ?? Response::MESSAGES[$code],
        ]);
    }
}