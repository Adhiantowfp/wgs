<?php

namespace App\Actions\Fortify;

use App\Models\User\User;
use App\Models\User\User_Profile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Str;

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
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique(User::class)],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        // $user = User::orderBy('id', 'DESC')->first();

        // if ($user == Null) {
        //     $user_id = 'UMG0001';
        // } else {
        //     $numRow = $user->id + 1;

        //     if ( $numRow < 10 ) {
        //         $user_id = 'UMG' . '000' . $numRow;
        //     } elseif ( $numRow >= 10 && $numRow <= 99 ) {
        //         $user_id = 'UMG' . '00' . $numRow;
        //     } elseif ( $numRow >= 100 && $numRow <= 999 ) {
        //         $user_id = 'UMG' . '0' . $numRow;
        //     } elseif ( $numRow >= 1000 && $numRow <= 9999 ) {
        //         $user_id = 'UMG' . $numRow;
        //     }
        // }

        $user_id = 'TEST_ID';

        User_Profile::create([
            'user_id' => $user_id,
            'name' => $input['name'],
        ]);

        return User::create([
            'user_id' => $user_id,
            'name' => $input['name'],
            'role' => 'User',
            'username' => $input['username'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'api_token' => Str::random(60),
        ]);
    }
}
