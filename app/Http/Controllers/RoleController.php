<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function assignRole(Request $request, $id)
    {
        $user = User::find($id);
        if(!$user)
        {
            return response()->json(['message' => 'This user doesn\'t exist!']);
        }

        $user->syncRoles([$request->name]);

        return response()->json([
            'status' => true,
            'message' => 'Role assigned successfully!',
        ]);
    }

    public function removeRole(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['Message' => "This user doesn't exist!"]);
        }

        // $roleName = $request->name;

        // if(!$user->hasRole($roleName)){
        //     return response()->json(['Message' => "This user doesn't have ({$roleName}) role!"]);
        // }

        $user->syncRoles('user');

        return response()->json([
            'Message' => 'Role removed successfully!',
        ]);
    }
}
