<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // 🔎 Search by name or email
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%')
                  ->orWhere('phone_number', 'like', '%'.$request->search.'%');
            });
        }

        // 🎯 Filter by user_type
        if ($request->filled('user_type')) {
            $query->where('user_type', $request->user_type);
        }

        // 📍 Filter by city
        if ($request->filled('city')) {
            $query->where('city_district_town', 'like', '%'.$request->city.'%');
        }

        // 📅 Date-wise filter (created_at)
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->from_date)->startOfDay(),
                Carbon::parse($request->to_date)->endOfDay(),
            ]);
        } elseif ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        } elseif ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // 🛒 Count how many orders each user placed
        $query->withCount('orders');

        // 📑 Paginate results (10 per page)
        $users = $query->orderBy('id', 'desc')->paginate(10);

        // Keep query string in pagination links
        $users->appends($request->all());

        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],

            'phone_number' => 'nullable|regex:/^[0-9]{10}$/',
            'zip_postal_code' => 'nullable|string|max:20',
            'locality_house_no' => 'nullable|string|max:255',
            'street_address' => 'nullable|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'city_district_town' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',

            'company_name' => 'nullable|string|max:255',
            'gst_no' => 'nullable|regex:/^[A-Z0-9]{15}$/',

            'user_type' => 'required|in:user,guest,admin',
        ]);

        $user->update($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }
    
    public function changePassword(Request $request, User $user){
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Password updated successfully',
        ]);
    }
    
    public function toggleBlock(User $user){
        $user->blocked_at = $user->blocked_at ? null : now();
        $user->save();

        return response()->json([
            'blocked' => $user->blocked_at !== null,
            'message' => $user->blocked_at
                ? 'User has been blocked'
                : 'User has been unblocked',
        ]);
    }
    
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',

            'phone_number' => 'nullable|regex:/^[0-9]{10}$/',
            'city_district_town' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',

            'company_name' => 'nullable|string|max:255',
            'gst_no' => 'nullable|regex:/^[A-Z0-9]{15}$/',

            'user_type' => 'required|in:user,guest,admin',
        ]);

        User::create([
            ...$validated,
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

}
