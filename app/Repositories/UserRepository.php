<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;

class UserRepository implements UserRepositoryInterface
{
    public function getAll(): Collection
    {
        return User::all('name', 'email');
    }

    public function getOne($id)
    {
        try {
            $user = User::where('id', $id)->firstOrFail();
        } catch(Exception $e) {
            return ['error' => 'Usuario no encontrado'];
        }
        return $user;
    }
}
