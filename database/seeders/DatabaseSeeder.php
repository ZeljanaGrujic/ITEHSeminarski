<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Order;
use App\Models\OrderStatus;
use Database\Factories\OrderFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            RoleSeeder::class
        ]);
        \App\Models\Language::factory(3)->create();
        \App\Models\Category::factory(3)->create();
        \App\Models\OrderStatus::factory(5)->create();
        \App\Models\User::factory(10)->create();
        \App\Models\Book::factory(100)->create();
        \App\Models\Author::factory(10)->create();
        Order::factory(100)->create();

        for ($i = 0; $i < 1000; $i++) {
            DB::insert('insert into books_orders (book_id, order_id, quantity) values (?, ?, ?)', [Book::all()->random()->id, Order::all()->random()->id, rand(1, 3)]);
        }
    }
}
