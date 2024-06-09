<?php
namespace App\Services;
use App\Repositories\UserRepository;

class AuthService {
    public function __construct(protected UserRepository $userRepository) {}

    public function login(array $credentials) {
    }

    public function register(array $data) {
        return $this->userRepository->createUser($data);
    }

}

