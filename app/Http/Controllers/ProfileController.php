<?php

namespace App\Http\Controllers;

use App\Events\ProfileUpdated;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validated();
        $changedFields = [];

        foreach ($validated as $key => $value) {
            if ($user->{$key} !== $value) {
                $changedFields[] = $key;
            }
        }

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            if (! in_array('email_verified_at', $changedFields)) {
                $changedFields[] = 'email_verified_at';
            }
        }

        $user->save();

        if (! empty($changedFields) && $user->user_type === 'user') {
            event(new ProfileUpdated($user, $changedFields, 'profile'));
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update address
     */
    public function update_address(Request $request)
    {

        $validated = $request->validate([
            'phone_number' => ['required', 'string', 'max:20'],
            'zip_postal_code' => ['nullable', 'string', 'max:20'],
            'locality_house_no' => ['nullable', 'string', 'max:255'],
            'street_address' => ['nullable', 'string', 'max:255'],
            'landmark' => ['nullable', 'string', 'max:255'],
            'city_district_town' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'gst_no' => ['nullable', 'regex:/^[A-Z0-9]{15}$/'],
        ], [
            'gst_no.regex' => 'Please enter a valid GST number (15 characters, A–Z and 0–9 only).',
        ]);

        $user = $request->user();

        $changedFields = [];

        foreach ($validated as $key => $value) {
            if ($user->{$key} !== $value) {
                $changedFields[] = $key;
            }
        }

        if (! empty($changedFields)) {
            $user->update($validated);

            if ($user->user_type === 'user') {
                event(new ProfileUpdated($user, $changedFields, 'address'));
            }
        }

        return Redirect::route('profile.edit')->with('status', 'address-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
