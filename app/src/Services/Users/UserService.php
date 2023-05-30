<?php

namespace App\Services\Users;

use App\Entity\Users\User;
use App\Repository\Users\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private UserRepository $userRepository
    ) {
    }

    public function createUser(User $user): User
    {
        $plainPassword = $user->getPassword();
        $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);

        $user->setUsername($user->getUsername());
        $user->setEmail($user->getEmail());

        $this->userRepository->save($user, true);

        return $user;
    }
}
