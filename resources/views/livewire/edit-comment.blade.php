<div>
    @if ($editingComment)
        <form wire:submit.prevent="update" wire:loading.attr="disabled" class="space-y-4">
            {{-- تعويض $this->form --}}
            <div>
                <label for="body" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                    {{ __('nested-comments::nested-comments.comments.form.fields.body') }}
                </label>
                <textarea wire:model.defer="data.body" id="body" rows="4"
                    class="block w-full mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-white"
                    placeholder="{{ __('nested-comments::nested-comments.comments.form.placeholders.body') }}"></textarea>
                @error('data.body')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

            </div>

            {{-- زر الحفظ --}}
            <button type="submit"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                {{ __('nested-comments::nested-comments.comments.form.buttons.save') }}
            </button>

            {{-- زر الإلغاء --}}
            <button type="button" wire:click="showForm(false)"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-800 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
                {{ __('nested-comments::nested-comments.comments.form.buttons.cancel') }}
            </button>
        </form>
    @else
        <div wire:click.prevent.stop="showForm(true)" class="relative w-full">
            <div
                class="flex items-center px-3 py-2 text-gray-700 transition bg-white border border-gray-300 rounded-md shadow-sm cursor-pointer dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                {{-- أيقونة القلم --}}
                <svg class="w-5 h-5 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.232 5.232l3.536 3.536M9 11l6 6M3 21h6l11-11a2.828 2.828 0 00-4-4L5 17H3v2z" />
                </svg>
                <span class="text-sm">
                    {{ __('nested-comments::nested-comments.comments.form.buttons.edit_comment') }}
                </span>
            </div>
        </div>
    @endif

    {{-- المحاكاة البديلة لـ <x-filament-actions::modals /> --}}
    {{-- تقدر تحط المودال هنا لاحقاً إذا بتحتاجه، مؤقتًا نتركه فاضي --}}
</div>

{{-- <div>
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
</div> --}}
