<?php

namespace App\Repositories;

interface UserRepositoryInterface {
    public function getAll();
    public function getById($id);
    public function createUser(array $data);
    public function updateUser($id, array $data);
    public function delete($id);

    public function getByUserName($username);

}
