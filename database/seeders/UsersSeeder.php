<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('users')->delete();

        \DB::table('users')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Super Admin',
                'email' => 'itech@gmail.com',
                'phone' => NULL,
                'country' => NULL,
                'city' => NULL,
                'state' => NULL,
                'post_code' => NULL,
                'address' => NULL,
                'nid' => '3242465654',
                'tin' => NULL,
                'address_secondary' => NULL,
                'email_verified_at' => NULL,
                'email_verified' => NULL,
                'password' => '$2y$10$ysPEG.KTuUoch3EHmSYcQOcLyFbQFPOz95vmUb5Ey.q0cMeg5zyfa',
                'reset_password_code' => NULL,
                'remember_token' => NULL,
                'profile_photo_path' => '',
                'default_module_id' => 0,
                'role' => 0,
                'created_at' => '2021-01-26 11:53:42',
                'updated_at' => '2021-07-01 07:01:13',
                'status' => 1,
                'balance' => '0.00',
                'is_social_login' => 0,
                'google_id' => NULL,
                'fb_id' => NULL,
                'social_image_link' => NULL,
                'date_of_birth' => NULL,
                'time_zone' => NULL,
                'language' => 'de',
                'admin_verified' => 1,
                'nid_picture' => '',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'phone' => NULL,
                'country' => NULL,
                'city' => NULL,
                'state' => NULL,
                'post_code' => NULL,
                'address' => NULL,
                'nid' => NULL,
                'tin' => NULL,
                'address_secondary' => NULL,
                'email_verified_at' => NULL,
                'email_verified' => NULL,
                'password' => '$2y$10$DBaILPlJRhS1s3U/kqboNen9SyYVKRpaTuSTetqct11JCkuaPUt2W',
                'reset_password_code' => NULL,
                'remember_token' => 'Hh0UW6I2DtMluSGkXJ5p5zfqOquq5MRQuI4eXNysl0KfnN0UVpRVS6dOpBqp',
                'profile_photo_path' => NULL,
                'module_id' => 1,
                'role' => 1,
                'created_at' => '2021-01-27 10:27:19',
                'updated_at' => '2021-07-02 06:15:31',
                'status' => 1,
                'balance' => '210.00',
                'is_social_login' => 0,
                'google_id' => NULL,
                'fb_id' => NULL,
                'social_image_link' => NULL,
                'date_of_birth' => NULL,
                'time_zone' => NULL,
                'language' => NULL,
                'admin_verified' => 1,
                'nid_picture' => NULL,
            )
        ));


    }
}
