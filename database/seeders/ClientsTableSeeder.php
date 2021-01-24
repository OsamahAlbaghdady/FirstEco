<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = ['Osamah' , 'zaid'];
        foreach ($clients as $client) {
            Client::create([
                'name' => $client,
                'phone'=>['964' , '770'],
                'address' => 'baghdad'
            ]);
        }
    }
}
