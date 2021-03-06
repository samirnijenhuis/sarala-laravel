<?php

declare(strict_types=1);

namespace Sarala;

use Sarala\Dummy\Post;
use Sarala\Dummy\Comment;

class PostCollectionTest extends TestCase
{
    public function test_can_fetch_posts()
    {
        factory(Post::class, 10)->create();

        $this->withJsonApiHeaders('get', route('posts.index'))
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'type',
                        'attributes' => [
                            'slug',
                            'title',
                            'subtitle',
                            'created_at',
                            'updated_at',
                            'published_at',
                        ],
                        'links' => [
                            'self',
                        ],
                    ],
                ],
            ]);
    }

    public function test_can_fetch_a_posts_with_comments_and_author()
    {
        factory(Comment::class, 10)->create();

        $url = route('posts.index').'?include=comments.author';

        $this->withJsonApiHeaders('get', $url)
            ->assertOk();
    }
}
