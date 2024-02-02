<?php

namespace Database\Seeders;

use App\Models\PostCommentReport;
use Illuminate\Database\Seeder;

class PostCommentReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PostCommentReport::factory()->count(10)->create();
    }
}
