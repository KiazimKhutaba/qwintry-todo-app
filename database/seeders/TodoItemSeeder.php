<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TodoItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Simple todos

        $todoItems = [
            [
                'text' => 'Thing1',
                'is_done' => false,
                'is_urgent' => false
            ],
            [
                'text' => 'Buy milk',
                'is_done' => false,
                'is_urgent' => false
            ],
            [
                'text' => 'Thing2',
                'is_done' => true,
                'is_urgent' => false
            ],
            [
                'text' => 'Thing3',
                'is_done' => true,
                'is_urgent' => false
            ],
            [
                'text' => 'Buy bread',
                'is_done' => false,
                'is_urgent' => true
            ],
            [
                'text' => 'Fix door',
                'is_done' => false,
                'is_urgent' => true
            ],
            [
                'text' => 'Pay all the invoices',
                'is_done' => false,
                'is_urgent' => true
            ],
            [
                'text' => 'Another thing',
                'is_done' => false,
                'is_urgent' => true
            ]
        ];

        foreach ($todoItems as $todoItem)
        {
            DB::table('todo_items')
                ->insert($todoItem + [
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
        }
    }
}
