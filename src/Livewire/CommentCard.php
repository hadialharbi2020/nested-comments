<?php

namespace Hadialharbi\NestedComments\Livewire;

use Error;
use Filament\Support\Concerns\EvaluatesClosures;
use Hadialharbi\NestedComments\Models\Comment;
use Hadialharbi\NestedComments\NestedCommentsServiceProvider;
use Livewire\Component;

class CommentCard extends Component
{
    use EvaluatesClosures;

    public bool $isEditing = false;

    public ?string $editedBody = null;

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
        $this->editedBody = $comment->body;

    }

    public function render()
    {
        $namespace = NestedCommentsServiceProvider::$viewNamespace;

        return view("$namespace::livewire.comment-card");
    }

    /**
     * Refresh the nested replies for the current comment.
     */
    public function refreshReplies(): void
    {
        if ($this->comment) {
            $this->comment->load('replies'); // تحميل الردود فقط
        }
    }

    public function toggleReplies(): void
    {
        $this->replyingToCommentId = ($this->replyingToCommentId === $this->comment->id) ? null : $this->comment->id;
    }

    public function getAvatar()
    {
        if (! $this->comment) {
            return '';
        }

        /**
         * @phpstan-ignore-next-line
         */
        return $this->comment->commentable?->getUserAvatarUsing($this->comment);
    }

    public function getCommentator(): string
    {
        if (! $this->comment) {
            return '';
        }

        /**
         * @phpstan-ignore-next-line
         */
        return $this->comment->commentable?->getUserNameUsing($this->comment);
    }

    public function updateComment(): void
    {
        // abort_unless(auth()->id() === $this->comment->user_id, 403);

        $this->validate([
            'editedBody' => 'required|string|min:1',
        ]);

        $this->comment->update(['body' => $this->editedBody]);
        $this->isEditing = false;
    }

    /**
     * Delete the current comment and dispatch an event.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function deleteComment(): void
    {
        // التحقق من الصلاحيات: إما أن يكون المستخدم هو صاحب التعليق أو يملك إذنًا
        // if ($this->comment->user_id) {
        //     abort_unless(auth()->id() === $this->comment->user_id, 403, 'غير مصرح لك بحذف هذا التعليق.');
        // } else {
        //     // للضيوف: يمكن إضافة منطق تحقق إضافي (مثل رمز جلسة)
        //     abort_unless(session('guest_comment_token') === $this->comment->guest_token, 403, 'غير مصرح لك بحذف هذا التعليق.');
        // }

        $commentId = $this->comment->id;
        $parentId = $this->comment->parent_id;
        $this->comment->delete();
        $this->dispatch('comment-deleted', id: $commentId, parentId: $parentId);
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
            // التعليق الحالي تم حذفه
            $this->comment = null;
        } elseif ($this->comment && $this->comment->id === $parentId) {
            // أحد الردود المتداخلة تم حذفه، تحديث الردود
            $this->comment->load('children'); // تحميل العلاقة children
        }
    }

    public function enableEditing(): void
    {
        $this->isEditing = true;
    }

    public function cancelEditing(): void
    {
        $this->isEditing = false;
        $this->editedBody = $this->comment->body;
    }
}
