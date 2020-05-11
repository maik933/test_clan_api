<?php

namespace vendor;

class Validator
{
    /** @var ValidationFactory */
    private $validationFactory;

    public function __construct()
    {
        $this->validationFactory = new ValidationFactory();
    }

    /**
     * @param ValidatorInterface $validation
     * @param array $data
     * @param string $group
     */
    public function execute (ValidatorInterface $validation, array $data, string $group): array
    {
        $errors = [];

        $precepts = $validation->getPrecept();
        foreach($precepts as $id => $precept) {
            foreach ($precept as $key => $value) {
                $error = $this->validationFactory
                    ->getValidation($key)
                    ->execute($this->getValueById($id, $data), $value, $group);
                if (null === $error) {
                    continue;
                }

                $errors[$id][] = $error;
            }
        }

        return $errors;
    }

    /**
     * @param string $id
     * @param array $data
     * @return mixed
     */
    private function getValueById (string $id, array $data)
    {
        foreach (explode('.', $id) as $value) {
            $data = $data[$value];
        }

        return $data;
    }
}
