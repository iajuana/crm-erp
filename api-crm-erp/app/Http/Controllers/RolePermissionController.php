<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get("search");

        $roles = Role::with(["permissions"])->where("name", "like","%".$search."%")->orderBy("id", "desc")->paginate(25);

        return response()->json([
            "total" => $roles->total(),
            "roles" => $roles->map(function ($rol) {
                $rol->permission_pluck = $rol->permissions->pluck("name");
                $rol->created_at = $rol->created_at->format("d-m-Y h:i A");
                return $rol;
            }),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $IS_ROLE = Role::where("name",$request->name)->first();
        if($IS_ROLE) {
            return response()->json([
                "message" => 403,
                "message_text" => "EL ROL YA EXISTE"

            ]);
        }
        $role = Role::create([
            'guard_name' => 'api',
            'name' => 'Super-Admin'
        ]);

        foreach ($request->permissions as $key => $permission) {
            $role->givePermissionTo($permission);
        }

        return response()->json([
            "message" => 200,
            "role" => [
                "id" => $role->id,
                "permission" => $role->permissions,
                "permission_pluck" => $role->permissions->pluck("name"),
                "created_at" => $role->created_at->format("d-m-Y h:i A"),
                "name" => $role->name,
            ]
        ]);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Buscar el rol
        $role = Role::with('permissions')->findOrFail($id);

        return response()->json([
            'role' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $IS_ROLE = Role::where("name", $request->name)->where("id", "<>", $id)->first();
        if($IS_ROLE) {
            return response()->json([
                "message" => 403,
                "message_text" => "EL ROL YA EXISTE"

            ]);
        }
        $role = Role::findOrFail($id);
        $role->update($request->all());        

        $role->syncPermissions($request->permissions);

        return response()->json([
            "message" => 200,
            "role" => [
                "id" => $role->id,
                "permission" => $role->permissions,
                "permission_pluck" => $role->permissions->pluck("name"),
                "created_at" => $role->created_at->format("d-m-Y h:i A"),
                "name" => $role->name,
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Buscar el rol
        $role = Role::findOrFail($id);

        // Eliminar el rol
        $role->delete();

        return response()->json([
            'message' => 200,
            'message_text' => "Rol eliminado exitosamente"
        ]);
    }
}
