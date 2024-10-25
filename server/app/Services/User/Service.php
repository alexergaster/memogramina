<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Service
{
  public function register(array $data): User
  {
    $data['password'] = Hash::make($data['password']);
    return User::create($data);
  }
}
