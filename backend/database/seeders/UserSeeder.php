<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Documents\User;
use App\Documents\Role;

use Doctrine\ODM\MongoDB\DocumentManager;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $dm = app(DocumentManager::class);

        $role = $dm
            ->getRepository(Role::class)
            ->findOneBy([
                'code'=>'SUPER_ADMIN'
            ]);

        $user = new User();

        $user->setName(
            'Siddharth'
        );

        $user->setUsername(
            'admin'
        );

        $user->setEmail(
            'admin@gmail.com'
        );

        $user->setMobileNo(
            '9999999999'
        );

        $user->setPassword(
            password_hash(
                'admin123',
                PASSWORD_BCRYPT
            )
        );

        $user->setRole(
            $role
        );

        $dm->persist($user);

        $dm->flush();
    }
}