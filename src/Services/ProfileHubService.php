<?php

namespace BabeRuka\ProfileHub\Services;

use BabeRuka\ProfileHub\Models\User; // Assuming you have a User model or a similar profile model
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfileHubService
{
    /**
     * Get a user profile by their ID.
     *
     * @param int $userId
     * @return \App\Models\User|null
     */
    public function getUserProfile(int $userId): ?User
    {
        return User::find($userId);
    }

    /**
     * Update a user's profile information.
     *
     * @param int $userId
     * @param array $data
     * @return \App\Models\User|null
     */
    public function updateUserProfile(int $userId, array $data): ?User
    {
        $user = User::find($userId);

        if ($user) {
            $user->fill($data);
            $user->save();
            return $user;
        }

        return null;
    }

    /**
     * Create a new user profile.
     *
     * @param array $data
     * @return \App\Models\User
     */
    public function createUserProfile(array $data): User
    {
        return User::create($data);
    }

    /**
     * Delete a user profile by their ID.
     *
     * @param int $userId
     * @return bool
     */
    public function deleteUserProfile(int $userId): bool
    {
        return User::destroy($userId) > 0;
    }

    /**
     * Generate a unique username (example).
     *
     * @param string $name
     * @return string
     */
    public function generateUniqueUsername(string $name): string
    {
        $slug = Str::slug($name);
        $count = User::where('username', 'like', $slug . '%')->count();

        return $count > 0 ? $slug . '-' . ($count + 1) : $slug;
    }

    // - Updating passwords
    // - Managing profile visibility settings
    // - Handling profile ছবি uploads
    // - Fetching lists of users based on certain criteria
    // - Implementing search functionality for profiles
}