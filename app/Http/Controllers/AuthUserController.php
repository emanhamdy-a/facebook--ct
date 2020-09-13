<?php

namespace App\Http\Controllers;

use App\Http\Resources\Auth as AuthResource;
use Illuminate\Http\Request;

class AuthUserController extends Controller
{
    public function show()
    {
      return new AuthResource(auth()->user());
    }
}
