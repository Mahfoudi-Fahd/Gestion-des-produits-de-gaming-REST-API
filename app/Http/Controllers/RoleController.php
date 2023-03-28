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
    public function index()
    {
        $roles = Role::all();
        return response()->json([
            'status' => true,
            'message' => 'Roles retrieved successfully!',
            'data' => RoleResource::collection($roles),
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request);

        return response()->json([
            'status' => true,
            'message' => 'Role created successfully!',
            'data' => new RoleResource($role),
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return response()->json([
            'status' => true,
            'message' => 'Role retrieved successfully!',
            'data' => new RoleResource($role->load('permissions')),
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permission_id);

        return response()->json([
            'status' => true,
            'message' => 'Role updated successfully!',
            'data' => new RoleResource($role),
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {

        $role->delete();

        return response()->json([
            'status' => true,
            'message' => "Role deleted successfully!",
        ], Response::HTTP_OK);
    }
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
