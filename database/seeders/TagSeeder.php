<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $tags = [
            // Happy/Positive Moods
            ['name' => 'Achievement', 'mood' => 'happy'],
            ['name' => 'Love', 'mood' => 'happy'],
            ['name' => 'Friendship', 'mood' => 'happy'],
            ['name' => 'Vacation', 'mood' => 'happy'],
            ['name' => 'Graduation', 'mood' => 'happy'],
            ['name' => 'Birthday', 'mood' => 'happy'],
            ['name' => 'Adventure', 'mood' => 'happy'],
            ['name' => 'Success', 'mood' => 'happy'],

            // Reflective/Thoughtful Moods
            ['name' => 'Memories', 'mood' => 'reflective'],
            ['name' => 'Life Lessons', 'mood' => 'reflective'],
            ['name' => 'Wisdom', 'mood' => 'reflective'],
            ['name' => 'Future Goals', 'mood' => 'reflective'],
            ['name' => 'Self-Improvement', 'mood' => 'reflective'],

            // Nostalgic Moods
            ['name' => 'Childhood', 'mood' => 'nostalgic'],
            ['name' => 'Old Friends', 'mood' => 'nostalgic'],
            ['name' => 'Past Times', 'mood' => 'nostalgic'],
            ['name' => 'Family History', 'mood' => 'nostalgic'],
            
            // Sad/Serious Moods
            ['name' => 'Goodbye', 'mood' => 'sad'],
            ['name' => 'Loss', 'mood' => 'sad'],
            ['name' => 'Regret', 'mood' => 'sad'],
            ['name' => 'Challenge', 'mood' => 'serious'],
            ['name' => 'Struggle', 'mood' => 'serious'],

            // Funny/Lighthearted Moods
            ['name' => 'Jokes', 'mood' => 'funny'],
            ['name' => 'Embarrassing Moments', 'mood' => 'funny'],
            ['name' => 'Silly Stories', 'mood' => 'funny'],
            ['name' => 'Pranks', 'mood' => 'funny'],

            // Romantic Moods
            ['name' => 'First Date', 'mood' => 'romantic'],
            ['name' => 'Secret Crush', 'mood' => 'romantic'],
            ['name' => 'Love Letter', 'mood' => 'romantic'],

            // Inspirational Moods
            ['name' => 'Dreams', 'mood' => 'inspirational'],
            ['name' => 'Hope', 'mood' => 'inspirational'],
            ['name' => 'Motivation', 'mood' => 'inspirational'],
        ];

        DB::table('tags')->insert($tags);
    }
}
    