<?php

namespace App\Imports;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ContactsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        Log::info('Importing row:', $row);
        $existingUser = User::where('email', $row['email'])->first();
        if ($existingUser) {
            $user = $existingUser;
            Log::info("Existing user found: {$user->email}");
        } else {
            $defaultPhotoPath = 'photos/user.jpg';
            $user = User::create([
                'name' => $row['first_name'] . ' ' . $row['last_name'],
                'email' => $row['email'],
                'password' => Hash::make('12345678'),
                'owner_id' => auth()->id(),
                'plan_id' => null,
                'photo' => $defaultPhotoPath,
            ]);    
            $user->assignRole('Contact');        
            Log::info("New user created: {$user->email}");
        }

        $contact = new Contact([
            'user_id' => $user->id,
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'specialty' => null,
            'gender' => $row['gender'],
            'birth' => $row['birth'],
            'phone' => $row['phone'],
            'country' => 1,
            'city' => 3,
            'is_active' => true,
        ]);

        Log::info('Contact ready for insert:', $contact->toArray());

        return $contact;
    }
}