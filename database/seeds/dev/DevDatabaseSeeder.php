<?php

use App\Models\Comment;
use App\Models\NewsletterSubscription;
use App\Models\Post;
use App\Models\Token;
use App\Models\User;
use Illuminate\Database\Seeder;

class DevDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Posts
        $post = Post::query()->firstOrCreate(
            [
                'title' => 'Hello World',
                'author_id' => $user->id
            ],
            [
                'posted_at' => now(),
                'content' => "
                    Welcome to Laravel-blog !<br><br>
                    Don't forget to read the README before starting.<br><br>
                    Feel free to add a star on Laravel-blog on Github !<br><br>
                    You can open an issue or (better) a PR if something went wrong."
            ]
        );

        // Comments
        Comment::query()->firstOrCreate(
            [
                'author_id' => $user->id,
                'post_id' => $post->id
            ],
            [
                'posted_at' => now(),
                'content' => "Hey ! I'm a comment as example."
            ]
        );

        // API tokens
        User::query()->where('api_token', null)->get()->each->update([
            'api_token' => Token::generate()
        ]);

        factory(Post::class, 20)
            ->create()
            ->each(function ($post) {
                factory(Comment::class, 5)
                    ->create([
                        'post_id' => $post->id
                    ]);
            });

        factory(NewsletterSubscription::class, 5)->create();
    }
}
