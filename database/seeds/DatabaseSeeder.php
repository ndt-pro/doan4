<?php

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->ins_admins();
    }

    public function ins_admins() {
        $admin = new Admin();
        
        $admin->username = "admin";
        $admin->password = Hash::make("toan080199");
        $admin->full_name = "Nguyễn Đức Toàn";
        $admin->avatar = "avatar.jpg";

        $admin->save();
    }

    public function ins_user() {
        for($i = 0; $i < 10; $i++) {
            $user = new User();
            
            $user->email = "admin";
            $user->password = Hash::make("toan080199");
            $user->full_name = "Nguyễn Đức Toàn";
            $user->avatar = "avatar.jpg";
    
            $user->save();
        }
    }
}
