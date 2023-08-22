<?php

namespace Database\Seeders;

use App\Models\PostCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoriesName = [
            'Tech', // noticias e comentarios sobre determinada tecnologia, linguagem, framwork e etc.
            'Qualificações', // exibir certificados e experiencias de aprendizado que me qualificam mais
            'Videos', // videos sobre tudo
            'Reviews', // reviews sobre determinada tecnologia, assunto ou curso. Review sobre qualuqer vcoisa de outra categoria
            'Portfolio' // Exibir projetos feitos
        ];
        foreach ($categoriesName as $key => $category) {
            //PostCategory::factory()->count(12)->create();
            $slug = str()->slug($category);
            PostCategory::factory()->set('name', $category)->set('slug', $slug)->create();
        }
    }
}
