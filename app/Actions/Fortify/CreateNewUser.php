<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'student_id' => ['required', 'digits:8', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'regex:/unistra\.fr$/i', 'unique:users'],
            'email_notifications' => [],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $input['email_notifications'] = array_key_exists('email_notifications', $input)  ? true : false;

        return User::create([
            'student_id' => $input['student_id'],
            'is_admin' => false,
            'email' => $input['email'],
            'email_notifications' => $input['email_notifications'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
