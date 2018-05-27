<?php

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
        $this->call('UsersTableSeeder');
        $this->command->info('Usuarios creados y cargados');

        /*llamadas de seeds extras*/

        $this->call([
        	SystemTableSeeder::class,
        	]);
    }
}

class UsersTableSeeder extends Seeder 
{
    public function run()
    {
       //corriendo seeding para users
        $timer      = Carbon\Carbon::now()->format('Y-m-d H:i:s');
        
        $users =[
        'usuario1' => array(
                'user'      => 'Carlos Guillen',
                'email'     => 'code_dev@zoho.com',
                'password'  => bcrypt('123456')
                ),
        'usuario2' => array(
                'user'      => 'Paco',
                'email'     => 'phpunit1@gmail.com',
                'password'  => bcrypt('123456')
                ),
        ];

        foreach ($users as $value) {
            \DB::table('users')->insert([
            'name'          => $value['user'],
            'email'         => $value['email'],
            'password'      => $value['password'],
            'created_at'    => $timer,
            'updated_at'    => $timer
            ]);
        }
        
    }
}