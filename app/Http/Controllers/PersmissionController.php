<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Http\Resources\PermissionResource;


class PersmissionController extends Controller
{
    public function index() 
    {
        return PermissionResource::collection(Permission::all());
    }
}
