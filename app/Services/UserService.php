<?php
namespace App\Services;

use App\Repositories\UserRepositoryInterface;


class UserService {
    public function __construct(protected UserRepositoryInterface $userRepository) {}

    public function getAll()
    {
        return $this->userRepository->getAll();
    }

    public function getByUsername($username)
    {
        return $this->userRepository->getByUsername($username);
    }

    public function createUser(array $userData) {
        return $this->userRepository->createUser($userData);
    }
    public function getById(int $id)
    {
        return $this->userRepository->getById($id);
    }

    public function updateUser(int $id, array $userData)
    {
        return $this->userRepository->updateUser($id, $userData);
    }
    public function delete(int $id) {
        return $this->userRepository->delete($id);
    }
}
