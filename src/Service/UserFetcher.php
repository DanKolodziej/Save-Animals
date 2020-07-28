<?php

namespace App\Service;

use App\Repository\UserRepository;

class UserFetcher {

    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    /**
     * @param $id
     * @return \App\Entity\User
     */
    public function getUser($id): \App\Entity\User
    {
        return $this->userRepository->find($id);
    }
}