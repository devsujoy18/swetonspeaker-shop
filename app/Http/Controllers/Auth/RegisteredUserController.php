<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => ['required', 'numeric', 'digits:10'],
            'zip_postal_code' => ['required'],
            'locality_house_no' => ['required'],
            'street_address' => ['required'],
            'landmark' => ['required'],
            'city_district_town' => ['required'],
            'state' => ['required'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'zip_postal_code' => $request->zip_postal_code,
            'locality_house_no' => $request->locality_house_no,
            'street_address' => $request->street_address,
            'landmark' => $request->landmark,
            'city_district_town' => $request->city_district_town,
            'state' => $request->state,
        ]);

        event(new Registered($user));

        Auth::login($user);
        
        // Send email to the registered user
        Mail::to($user->email)->send(new WelcomeMail($user));

        // Send email to admin
        Mail::to('satnam1122@gmail.com')->send(new WelcomeMail($user, true));

        //return redirect(route('dashboard', absolute: false));
        return redirect()->intended(route('dashboard', absolute: false));
    }
}
