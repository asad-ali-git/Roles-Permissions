<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteRoleRequest;
use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);

        return $this->success(User::all(), UserResource::class, true);
    }

    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $additionalDetails = [
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ];
            User::create(array_merge($data, $additionalDetails));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw $e;
        }

        return $this->success([], null, false, trans('messages.user_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $this->authorize('view', User::class);

        return $this->success($user, UserResource::class);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', User::class);
        try {
            DB::beginTransaction();

            $user->update($request->validated());

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw $e;
        }

        return $this->success([], null, false, trans('messages.user_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user)
    {
        $this->authorize('delete', User::class);
        try {
            DB::beginTransaction();

            $user->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw $e;
        }

        return $this->success([], null, false, trans('messages.user_deleted'));
    }
}
