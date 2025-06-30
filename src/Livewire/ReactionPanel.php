<?php

namespace Hadialharbi\NestedComments\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class ReactionPanel extends Component
{
    protected $listeners = [
        'refresh' => '$refresh',
    ];

    public array $allReactions = [];

    public Model $record;

    public function mount(mixed $record = null): void
    {
        if (! $record?->getKey()) {
            throw new \Error('The Reactable $record property is required.');
        }
        $this->record = $record;
    }

    public function render(): View
    {
        $customView = resource_path('views/livewire/nested-comments/reaction-panel.blade.php');

        if (file_exists($customView)) {
            return view('livewire.nested-comments.reaction-panel');
        }

        return view('nested-comments::livewire.reaction-panel');
    }

    public function react($emoji): void
    {
        if (method_exists($this->record, 'react')) {
            $this->record->react($emoji);
            $this->dispatch('refresh')->self();
        }
    }
}
