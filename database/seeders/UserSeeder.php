<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->name = 'Данияр';
        $user->surname = 'Сатыбалдиев';
        $user->father_name = 'Искендербекович';
        $user->email = 'satybaldiev@gmail.com';
        $user->phone = '+996557225033';
        $user->password = Hash::make('20Deneme!');
        $user->save();
    }
}
