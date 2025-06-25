<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\CountryHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $popularCountryCodes = CountryHelper::getPopularCountryCodes();
        $allCountryCodes = CountryHelper::getCountryCodes();

        return view('auth.register', compact('popularCountryCodes', 'allCountryCodes'));
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:male,female,other'],
            'age_group' => ['required', 'in:below_20,20_to_32,32_to_45,45_to_60,60_to_70,above_70'],
            'email' => [
                'required',
                'string',
                'email:rfc,dns',
                'max:255',
                'unique:users',
                function ($attribute, $value, $fail) {
                    // Check for disposable email domains
                    $disposableDomains = ['mailinator.com', 'yopmail.com', 'tempmail.com', 'temp-mail.org', 'fakeinbox.com', 'guerrillamail.com'];
                    $domain = explode('@', $value)[1] ?? '';
                    if (in_array(strtolower($domain), $disposableDomains)) {
                        $fail('Please use a non-disposable email address.');
                    }
                },
            ],
            'country_code' => ['required', 'string', 'max:10'],
            'phone' => [
                'required',
                'string',
                'max:15',
                'unique:users',
                'regex:/^[0-9]{6,15}$/',
            ],
            'organization' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ], [
            'phone.regex' => 'Phone number should contain 6-15 digits only, without spaces or special characters.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered. Please login or use a different email.',
            'phone.unique' => 'This phone number is already registered. Please login or use a different number.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create the user
        User::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'age_group' => $request->age_group,
            'email' => $request->email,
            'country_code' => $request->country_code,
            'phone' => $request->phone,
            'organization' => $request->organization,
            'password' => Hash::make($request->password),
        ]);

        // Redirect to the login page with success message
        return redirect()->route('login')
            ->with('success', 'Account created successfully! Please log in with your credentials.');
    }
}
