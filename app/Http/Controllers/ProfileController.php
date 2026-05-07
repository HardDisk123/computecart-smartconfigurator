<?php

namespace App\Http\Controllers;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;


class ProfileController extends Controller
{
    /**
     * Display the user's profile (view-only page) with orders and wishlist.
     */
    public function show(): View
    {
        $user = Auth::user();

        // Fetch related data
        $orders = $user->orders()->latest()->get();
        $wishlist = $user->wishlist()->get();

        return view('customer.profile', compact('user', 'orders', 'wishlist'));
    }

    /**
     * Display the user's profile edit form.
     */
    public function edit(): View
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information including name, email, password, and profile picture.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'picture'  => 'nullable|image|max:2048',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('profile_pictures', 'public');
            $user->picture = $path;
        }

        $user->save();

        // ✅ Fix: redirect back to edit page with matching flash key
        return redirect()->route('profile.edit')->with('status', 'Profile updated successfully!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = Auth::user();
        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ✅ Fix: use same flash key for consistency
        return Redirect::route('home')->with('status', 'Account deleted.');
    }

    public function orders(Order $order)
{
    return view('profile.orders.index', compact('order'));
}


}
