<?php
use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'shoaibt51@gmail.com',
            'user_name' => 'Shoaib Tariq',
            'role' => 1,
            'is_active' => 1,
            'password' => bcrypt(123456789)
        ]);

    }
}
