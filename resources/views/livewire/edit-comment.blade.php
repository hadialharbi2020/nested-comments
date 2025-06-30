<div>
    @if ($editingComment)
        <form wire:submit.prevent="update" wire:loading.attr="disabled" class="space-y-4">
            {{ $this->form }}
            <x-filament::button type="submit">
                {{ __('nested-comments::nested-comments.comments.form.buttons.save') }}
            </x-filament::button>
            <x-filament::button type="button" color="gray" wire:click="showForm(false)">
                {{ __('nested-comments::nested-comments.comments.form.buttons.cancel') }}
            </x-filament::button>
        </form>
    @else
        <x-filament::input.wrapper :inline-prefix="true" prefix-icon="heroicon-o-pencil-square">
            <x-filament::input
                placeholder="{{ __('nested-comments::nested-comments.comments.form.buttons.edit_comment') }}"
                type="text" wire:click.prevent.stop="showForm(true)" :readonly="true" />
        </x-filament::input.wrapper>
    @endif
    <x-filament-actions::modals />
</div>
