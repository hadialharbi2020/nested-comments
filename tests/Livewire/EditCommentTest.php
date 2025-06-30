<?php

namespace Hadialharbi\NestedComments\Tests\Livewire;

use Hadialharbi\NestedComments\Livewire\EditComment;
use Hadialharbi\NestedComments\Models\Comment;
use Hadialharbi\NestedComments\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

class EditCommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_edit_form_with_existing_comment_body()
    {
        $comment = Comment::factory()->create([
            'body' => '<p>التعليق الأصلي</p>',
        ]);

        Livewire::test(EditComment::class, ['comment' => $comment])
            ->assertSet('data.body', function ($body) {
                return is_array($body)
                    && isset($body['content'][0]['content'][0]['text'])
                    && $body['content'][0]['content'][0]['text'] === 'التعليق الأصلي';
            });
    }

    /** @test */
    public function it_updates_comment_successfully()
    {
        $comment = Comment::factory()->create(['body' => 'قديم']);

        Livewire::test(EditComment::class, ['comment' => $comment])
            ->set('data.body', '<p>جديد</p>')
            ->call('update');

        $this->assertEquals('<p>جديد</p>', $comment->fresh()->body);

    }

    /** @test */
    public function it_validates_body_field()
    {
        $comment = Comment::factory()->create();

        Livewire::test(EditComment::class, ['comment' => $comment])
            ->set('data.body', '') // تركناه فاضي عمداً
            ->call('update')
            ->assertHasErrors(['data.body' => 'required']);
    }
}
