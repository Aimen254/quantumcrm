<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResponsesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('responses')->insert([
            ['keyword' => 'hello', 'response' => 'Hello, How can I assist you today?'],
            ['keyword' => 'how are you', 'response' => 'I\'m doing great, thank you for asking! How can I help you today?'],
            ['keyword' => 'meeting', 'response' => 'Sure! I will arrange the next meeting and notify you soon.'],
            // Add more responses as needed
        ]);
    }
}
