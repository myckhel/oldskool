<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;

class UsersImport implements ToModel, WithUpserts
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row[0] == 'Timestamp') {
            return null;
        }

        return new User([
            'created_at'    => $row[0],
            'firstname'     => $row[1],
            'lastname'      => $row[2],
            'email'         => $row[3],
            'phone'         => $row[4],
            'gender'        => $row[5],
            'dob'           => $row[6],
            'wedding_date'  => $row[7],
            'picture_url'   => $row[8],
            'address'       => $row[9],
            'password'      => Hash::make('password'),
        ]);
    }

    /**
     * @return string|array
     */
    public function uniqueBy()
    {
        return 'email';
    }
}
