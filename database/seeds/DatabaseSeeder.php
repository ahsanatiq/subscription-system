<?php

use Domain\OS;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OS::create([
            'name' => 'android',
            'test_endpoint' =>  config('app.url').'/platform/android',
            'test_username' => 'admin',
            'test_password' => '123',
            'prod_endpoint' => 'http://android.com/api/v1',
            'prod_username' => 'admin',
            'prod_password' => '123'
        ]);

        OS::create([
            'name' => 'ios',
            'test_endpoint' => config('app.url').'/platform/ios',
            'test_username' => 'admin',
            'test_password' => '123',
            'prod_endpoint' => 'http://apple.com/api/v1',
            'prod_username' => 'admin',
            'prod_password' => '123'
        ]);

    }
}
