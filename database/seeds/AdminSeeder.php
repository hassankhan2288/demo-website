<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
        	[
        		'name'=>'Yasir',
        		'email'=>'yasirnaeem@outlook.com',
        		'password'=>Hash::make("secure786")
        	]
        ]);
    }
}
