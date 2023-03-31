<?php

namespace Database\Seeders;

use App\Models\TicketStatus;
use Illuminate\Database\Seeder;

class TicketStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['status_name'=>'Open'], //first time
            ['status_name'=>'Answered'], //admin default replay
            ['status_name'=>'Customer Reply'], // customer replay
            ['status_name'=>'On Hold'], // manually can select
            ['status_name'=>'In Progress'], // manually can select
            ['status_name'=>'Closed'], // manually can select
        ];

        TicketStatus::truncate();
        foreach ($data as $status){
            TicketStatus::create($status);
        }

    }
}
