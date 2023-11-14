<?php

namespace Database\Seeders;

use App\Domain\Constants\UserRoles;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "Quang Huy";
        $user->email = "quanhuy@gmail.com";
        $user->password = "huy123456";
        $user->role = UserRoles::SUPER_ADMIN;
        $user->save();
    }
}
