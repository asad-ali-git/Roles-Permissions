<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteRoleRequest;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Role::class);

        return $this->success(Role::all(), RoleResource::class, true);
    }

    public function store(StoreRoleRequest $request)
    {
        $this->authorize('create', Role::class);
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $role = Role::create($data);
            $role->permissions()->sync($data['permission_ids']);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw $e;
        }

        return $this->success([], null, false, trans('messages.role_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $this->authorize('view', [Role::class, $role]);

        return $this->success($role, RoleResource::class, false);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->authorize('update', [Role::class, $role]);
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $role->update(Arr::except($data, ['permission_ids']));
            $role->permissions()->sync($data['permission_ids']);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw $e;
        }

        return $this->success([], null, false, trans('messages.role_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteRoleRequest $request, Role $role)
    {
        $request->validated();
        $this->authorize('delete', [Role::class, $role]);
        try {
            DB::beginTransaction();

            $role->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw $e;
        }

        return $this->success([], null, false, trans('messages.permission_deleted'));
    }
}
