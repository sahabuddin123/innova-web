<?php
use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        Admin::create([
            'name'      =>  'Sahab Uddin',
            'email'     =>  'innovacomputersbd@gmail.com',
            'password'  =>  bcrypt('icbd@3813#'),
        ]);
    }
}
