<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function assignRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string|in:product_manager,user_manager',
        ]);

        $user = User::find($request->user_id);
        $role = Role::firstOrCreate(['name' => $request->role, 'guard_name' => 'sanctum']);

        $user->assignRole($role);

        return response()->json([
            'message' => 'Role assigned successfully',
            'user' => $user,
            'role' => $role,
        ]);
    }
}