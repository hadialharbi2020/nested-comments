<?php

namespace Hadialharbi\NestedComments\Livewire;

use Error;
use Filament\Support\Concerns\EvaluatesClosures;
use Hadialharbi\NestedComments\Models\Comment;
use Hadialharbi\NestedComments\NestedCommentsServiceProvider;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CommentCard extends Component
{
    use EvaluatesClosures;

    public ?Comment $comment = null;

    public ?string $userAvatar = null;

    public ?string $userName = null;

    public ?int $replyingToCommentId = null;

    protected $listeners = [
        'refresh' => 'refreshReplies',
        'comment-deleted' => 'onCommentDeleted',
    ];

    public function mount(?Comment $comment = null): void
    {
        if (! $comment) {
            throw new Error('The $comment property is required.');
        }
        $this->comment = $comment;
    }

    public function render(): View
    {
        $customView = resource_path('views/livewire/nested-comments/comment-card.blade.php');

        if (file_exists($customView)) {
            return view('livewire.nested-comments.comment-card');
        }

        return view(NestedCommentsServiceProvider::$viewNamespace . '::livewire.comment-card');
    }

    /**
     * Refresh the nested replies for the current comment.
     */
    public function refreshReplies(): void
    {
        if ($this->comment) {
            $this->comment->load('children');
        }
    }

    /**
     * Toggle the visibility of replies for the current comment.
     */
    public function toggleReplies(): void
    {
        $this->replyingToCommentId = ($this->replyingToCommentId === $this->comment->id) ? null : $this->comment->id;
    }

    /**
     * Get the commentator's avatar for the current comment.
     */
    public function getAvatar(): string
    {
        return $this->comment?->commentable?->getUserAvatarUsing($this->comment) ?? '';
    }

    /**
     * Get the commentator's name for the current comment.
     */
    public function getCommentator(): string
    {
        return $this->comment?->commentator ?? '';
    }

    /**
     * Delete the current comment and dispatch an event.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function deleteComment(): void
    {

        $commentId = $this->comment->id;
        $parentId = $this->comment->parent_id;
        $this->comment->delete();
        $this->dispatch('comment-deleted', id: $commentId, parentId: $parentId);
        $this->dispatch('notify', message: 'تم حذف التعليق بنجاح!');
    }

    /**
     * Handle the comment-deleted event to update the UI, including nested replies.
     *
     * @param  int  $id  The ID of the deleted comment
     * @param  int|null  $parentId  The ID of the parent comment, if applicable
     */
    public function onCommentDeleted($id, $parentId = null): void
    {
        if ($this->comment && $this->comment->id === $id) {
            $this->comment = null;
        } elseif ($this->comment && $this->comment->id === $parentId) {
            $this->comment->load('children');
        }
    }
}
