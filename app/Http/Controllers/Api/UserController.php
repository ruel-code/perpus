<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = User::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('nim', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->role) {
            $query->where('role', $request->role);
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $users = $query->orderBy('created_at', 'desc')->get();
        return $this->success(UserResource::collection($users), 'Users retrieved successfully');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:user,admin',
            'nim' => 'nullable|string|unique:users',
            'phone_number' => 'nullable|string',
            'study_program' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'nim' => $request->nim,
            'phone_number' => $request->phone_number,
            'study_program' => $request->study_program,
            'address' => $request->address,
            'is_active' => true,
        ]);

        return $this->success(new UserResource($user), 'User created successfully', 201);
    }

    public function show(User $user)
    {
        return $this->success(new UserResource($user), 'User retrieved successfully');
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
            'nim' => 'nullable|string|unique:users,nim,' . $user->id,
            'phone_number' => 'nullable|string',
            'study_program' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        $user->update($request->only(['name', 'email', 'role', 'nim', 'phone_number', 'study_program', 'address']));

        return $this->success(new UserResource($user), 'User updated successfully');
    }

    public function destroy(User $user)
    {
        if ($user->loans()->whereIn('status', ['dipinjam', 'terlambat'])->exists()) {
            return $this->error('Cannot delete user with active loans', 400);
        }
        $user->delete();
        return $this->success(null, 'User deleted successfully');
    }

    public function resetPassword(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        $user->update(['password' => Hash::make($request->password)]);

        return $this->success(null, 'Password reset successfully');
    }

    public function toggleActive(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'activated' : 'deactivated';
        return $this->success(new UserResource($user), "User {$status} successfully");
    }
}
