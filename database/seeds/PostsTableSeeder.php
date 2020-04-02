<?php

use App\Tag;
use App\Post;
use App\User;
use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $author1 = User::create([
            'name' => 'Supriadi Roadman 2',
            'email' => 'supriadiroadman2@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $author2 = User::create([
            'name' => 'Supriadi',
            'email' => 'supriadi@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $author3 = User::create([
            'name' => 'Roadman',
            'email' => 'roadman@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $author4 = User::create([
            'name' => 'Siagian',
            'email' => 'siagian@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $category1 = Category::create([
            'name' => 'News'
        ]);
        $category2 = Category::create([
            'name' => 'Marketing'
        ]);
        $category3 = Category::create([
            'name' => 'Partnership'
        ]);
        $category4 = Category::create([
            'name' => 'Design'
        ]);

        $post1 = Post::create([
            'title' => 'We relocated our office to a new designed garage',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s',
            'content' => 'It has survived not only five centuries  It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop',
            'category_id' => $category1->id,
            'image' => 'posts/1.jpg',
            'user_id' => $author1->id,
        ]);

        $post2 = Post::create([
            'title' => 'Top 5 brilliant content marketing strategies',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s',
            'content' => 'It has survived not only five centuries  It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop',
            'category_id' => $category2->id,
            'image' => 'posts/2.jpg',
            'user_id' => $author2->id,
        ]);
        // Post::create bisa juga diganti dengan $author3->posts()->create
        // dalam contoh ini untuk post3 dan post4, post1 dan post2 memakai cara biasa
        // 'user_id' => $author3->id, tidak perlu lagi ditulis
        $post3 = $author3->posts()->create([
            'title' => 'Best practices for minimalist design with example',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s',
            'content' => 'It has survived not only five centuries  It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop',
            'category_id' => $category3->id,
            'image' => 'posts/3.jpg',
        ]);

        $post4 = $author4->posts()->create([
            'title' => 'Congratulate and thank to Maryam for joining our team',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s',
            'content' => 'It has survived not only five centuries  It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop',
            'category_id' => $category4->id,
            'image' => 'posts/4.jpg',
        ]);

        $tag1 = Tag::create([
            'name' => 'Jobs'
        ]);
        $tag2 = Tag::create([
            'name' => 'Customers'
        ]);
        $tag3 = Tag::create([
            'name' => 'Record'
        ]);
        $tag4 = Tag::create([
            'name' => 'Progress'
        ]);

        $post1->tags()->attach([$tag1->id, $tag2->id]);
        $post2->tags()->attach([$tag3->id, $tag4->id]);
        $post3->tags()->attach([$tag1->id, $tag2->id]);
        $post4->tags()->attach([$tag3->id, $tag4->id]);
    }
}
