<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Role::class);

        return $this->success(Role::get(), RoleResource::class, true);
    }

    public function store(StoreRoleRequest $request)
    {
        $this->authorize('create', Role::class);
        try {
            DB::beginTransaction();

            $roleCreated = Role::create($request->validated());
            $roleCreated->refresh();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw $e;
        }

        return $this->success($roleCreated, RoleResource::class, false, trans('messages.role_created'));
    }
}
