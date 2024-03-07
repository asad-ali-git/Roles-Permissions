<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeletePermissionRequest;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Permission::class);

        return $this->success(Permission::all(), PermissionResource::class, true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        $this->authorize('create', Permission::class);
        try {
            DB::beginTransaction();

            Permission::create($request->validated());

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw $e;
        }

        return $this->success([], null, false, trans('messages.permission_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        $this->authorize('view', [Permission::class, $permission]);

        return $this->success($permission, PermissionResource::class, false);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $this->authorize('update', [Permission::class, $permission]);
        try {
            DB::beginTransaction();

            $permission->update($request->validated());

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw $e;
        }

        return $this->success([], null, false, trans('messages.permission_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeletePermissionRequest $request, Permission $permission)
    {
        $request->validated();
        $this->authorize('delete', [Permission::class, $permission]);
        try {
            DB::beginTransaction();

            $permission->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw $e;
        }

        return $this->success([], null, false, trans('messages.permission_deleted'));
    }
}
