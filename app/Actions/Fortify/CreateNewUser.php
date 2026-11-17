<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Spatie\Permission\Models\Role;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     *
     * @throws ValidationException
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'nama' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', 'alpha_dash', Rule::unique(User::class)],
            'email' => [
                'nullable',
                'string',
                'email',
                'max:100',
                Rule::unique('users', 'email'),
            ],
            'no_telp' => ['nullable', 'string', 'max:20'],
            'password' => $this->passwordRules(),
        ])->validate();

        $pengguna = User::create([
            'nama' => $input['nama'],
            'username' => $input['username'],
            'email' => $input['email'],
            'no_telp' => $input['no_telp'] ?? null,
            'password' => Hash::make($input['password']),
            'is_aktif' => false,
            'is_disetujui' => false,
        ]);

        $pengguna->assignRole('peminjam');

        return $pengguna;
    }
}
