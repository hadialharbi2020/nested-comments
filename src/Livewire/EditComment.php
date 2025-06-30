<?php

namespace Hadialharbi\NestedComments\Livewire;

use Error;
use Exception;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use FilamentTiptapEditor\Concerns\HasFormMentions;
use FilamentTiptapEditor\TiptapEditor;
use Hadialharbi\NestedComments\Models\Comment;
use Hadialharbi\NestedComments\NestedCommentsServiceProvider;
use Illuminate\Contracts\View\View;
use Livewire\Component;

/**
 * @property Form $form
 */
class EditComment extends Component implements HasForms
{
    use HasFormMentions;
    use InteractsWithForms;

    public ?array $data = [];

    public bool $editingComment = false;

    public ?Comment $comment = null;

    public function mount(?Comment $comment): void
    {
        if (! $comment) {
            throw new Error('The $comment property is required.');
        }
        $this->comment = $comment;
        $this->form->fill(['body' => $comment->body]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TiptapEditor::make('body')
                    ->label(__('nested-comments::nested-comments.comments.form.field.comment.label'))
                    ->profile('minimal')
                    ->output(\FilamentTiptapEditor\Enums\TiptapOutput::Html)
                    ->extraInputAttributes(['style' => 'min-height: 12rem;'])
                    ->mentionItemsPlaceholder(__('nested-comments::nested-comments.comments.form.field.comment.mention_items_placeholder'))
                    ->emptyMentionItemsMessage(__('nested-comments::nested-comments.comments.form.field.comment.empty_mention_items_message'))
                    ->getMentionItemsUsing(fn (string $query) => $this->comment->commentable->getMentionsUsing($query))
                    ->maxContentWidth('full')
                    ->required()
                    ->autofocus(),
            ])
            ->statePath('data')
            ->model(config('nested-comments.models.comment', Comment::class));
    }

    /**
     * @throws Exception
     */
    public function update(): void
    {

        $data = $this->form->getState();

        $this->comment->update(['body' => $data['body']]);
        $this->dispatch('refresh');
        $this->showForm(false);
    }

    public function cancel(): void
    {
        $this->form->fill(['body' => $this->comment->body]);
        $this->showForm(false);
    }

    public function render(): View
    {
        $customView = resource_path('views/livewire/nested-comments/edit-comment.blade.php');

        if (file_exists($customView)) {
            return view('livewire.nested-comments.edit-comment');
        }

        return view(NestedCommentsServiceProvider::$viewNamespace . '::livewire.edit-comment');
    }

    public function showForm(bool $editing): void
    {
        $this->form->fill(['body' => $this->comment->body]);
        $this->editingComment = $editing;
    }
}
