<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function showManagementPage(){

        $data = "Management Page";
        return response()->json($data);
    }
}
