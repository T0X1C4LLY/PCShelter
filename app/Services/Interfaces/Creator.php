<?php

namespace App\Services\Interfaces;

use App\Models\User;

interface Creator
{
    /**
     * @param array{
     *     name: string,
     *     username: string,
     *     email: string,
     *     password: string,
     * } $userData
     */
    public function creatUser(array $userData): User;
}
