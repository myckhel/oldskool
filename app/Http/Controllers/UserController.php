<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function import()
    {
        Excel::import(new UsersImport, 'Hope High School Old Soldier Members.csv');

        return redirect('/')->with('success', 'All good!');
    }
}
