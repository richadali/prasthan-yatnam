<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Helpers\CountryHelper;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the user profile.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $user = Auth::user();

        // Get enrolled courses count
        $enrolledCoursesCount = $user->enrolledDiscourses()->count();

        return view('profile.show', compact('user', 'enrolledCoursesCount'));
    }

    /**
     * Show the form for editing the user profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = Auth::user();
        $popularCountryCodes = CountryHelper::getPopularCountryCodes();
        $allCountryCodes = CountryHelper::getCountryCodes();

        return view('profile.edit', compact('user', 'popularCountryCodes', 'allCountryCodes'));
    }

    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
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
                Rule::unique('users')->ignore($user->id),
            ],
            'country_code' => ['required', 'string', 'max:10'],
            'phone' => [
                'required',
                'string',
                'max:15',
                Rule::unique('users')->ignore($user->id),
                'regex:/^[0-9]{6,15}$/',
            ],
            'organization' => ['required', 'string', 'max:255'],
        ]);

        $user->update($validated);

        return redirect()->route('profile.show')
            ->with('success', 'Your profile has been updated successfully.');
    }

    /**
     * Show the form for changing the user's password.
     *
     * @return \Illuminate\View\View
     */
    public function editPassword()
    {
        return view('profile.password');
    }

    /**
     * Update the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail('The current password is incorrect.');
                }
            }],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'different:current_password'],
        ]);

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.show')
            ->with('success', 'Your password has been updated successfully.');
    }
}
 