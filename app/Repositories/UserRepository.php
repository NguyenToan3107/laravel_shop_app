<?php

namespace App\Repositories;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{

    public function getAll()
    {
        return DB::table('users')->get();
    }

    public function getById($id)
    {
        return DB::table('users')->where('id', $id)->first();
    }

    public function createUser(array $data)
    {
        return DB::table('users')->insert($data);
    }

    public function updateUser($id, array $data)
    {
        return DB::table('users')->where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return DB::table('users')->where('id', $id)->delete();
    }

    public function getByUserName($username)
    {
        return DB::table('users')->where('name', $username)->first();
    }
}
