<?php

namespace Hadialharbi\NestedComments\Livewire;

use Hadialharbi\NestedComments\Concerns\HasComments;
use Hadialharbi\NestedComments\Models\Comment;
use Hadialharbi\NestedComments\NestedComments;
use Hadialharbi\NestedComments\NestedCommentsServiceProvider;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Livewire\Component;

class Comments extends Component
{
    /**
     * @var (Model&HasComments)|null
     */
    public ?Model $record = null;

    protected $listeners = [
        'refresh' => 'refreshComments',
    ];

    /**
     * @var Collection<Comment>
     */
    public Collection $comments;

    public function mount(): void
    {
        $this->comments = collect();

        if (! $this->record) {
            throw new \Error('Record model (Commentable) is required');
        }

        if (! app(NestedComments::class)->classHasTrait($this->record, HasComments::class)) {
            throw new \Error('Record model must use the HasComments trait');
        }

        $this->refreshComments();
    }

    // #[On('comment-deleted')]
    // #[On('refresh')]
    public function refreshComments(): void
    {
        $this->record = $this->record->refresh();
        if (method_exists($this->record, 'getCommentsTree')) {
            $this->comments = $this->record->getCommentsTree();
        }
    }

    public function render(): View
    {
        $customView = resource_path('views/livewire/nested-comments/comments.blade.php');

        if (file_exists($customView)) {
            return view('livewire.nested-comments.comments');
        }

        return view(NestedCommentsServiceProvider::$viewNamespace . '::livewire.comments');
    }
}
