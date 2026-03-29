<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    //
        public function profile()
    {
        $user = Auth::user();
        return view('backend.admin.profile', compact('user'));
    }

    /**
     * Update Admin Profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed', 
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Update fields
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        // Update password if provided
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        // Handle profile image
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image && file_exists(public_path($user->profile_image))) {
                unlink(public_path($user->profile_image));
            }

            // Upload new image
            $image = $request->file('profile_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload/user'), $imageName);

            // Save path to database
            $user->profile_image = 'upload/user/' . $imageName;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile Updated Successfully!');
    }
}
