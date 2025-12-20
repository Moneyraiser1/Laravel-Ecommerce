<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   // database/seeders/CategorySeeder.php

public function run()
{
    DB::table('categories')->truncate(); // <-- delete all existing categories

    $categories = ['Electronics', 'Fashion', 'Books', 'Home & Kitchen'];

    foreach ($categories as $cat) {
        \App\Models\Category::create(['category' => $cat]);
    }
}

}
