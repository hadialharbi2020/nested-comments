<div x-data wire:poll.15s dir="rtl" class="text-right">
    <div class="p-8 my-4 rounded-lg bg-gray-50 ring-gray-100 dark:bg-gray-950">
        <div class="flex flex-wrap items-center justify-between">
            <div x-data="{ showFullDate: false }" class="flex items-center space-x-2 space-x-reverse">
                <x-filament::avatar :src="$this->getAvatar()" :alt="$this->getCommentator()"
                    :name="$this->getCommentator()" size="md" :circular="false" />
                <div x-on:mouseover="showFullDate = true" x-on:mouseout="showFullDate = false" class="cursor-pointer">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                        {{ $this->getCommentator() }}
                    </p>
                    <p x-show="!showFullDate" class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $this->comment->created_at?->diffForHumans() }}
                    </p>
                    <p x-show="showFullDate" class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $this->comment->created_at->format(config('nested-comments.format-created-date', 'F j Y h:i:s
                        A')) }}
                    </p>
                </div>
            </div>

            @if(auth()->check() && auth()->id() === $this->comment->user_id)
            <div class="flex items-center gap-2">
                @if(!$isEditing)
                <x-filament::icon-button icon="heroicon-o-pencil-square" color="info" size="xs"
                    wire:click="enableEditing" />
                <x-filament::icon-button icon="heroicon-o-trash" color="danger" size="xs" wire:click="deleteComment" />
                @endif
            </div>
            @endif
        </div>

        <div class="my-4 prose text-right max-w-none dark:prose-invert">
            @if($isEditing)
            <x-filament::textarea wire:model.defer="editedBody" rows="4" />
            <div class="flex justify-end gap-2 mt-2">
                <x-filament::button color="success" size="sm" wire:click="updateComment">
                    حفظ
                </x-filament::button>
                <x-filament::button color="gray" size="sm" wire:click="cancelEditing">
                    إلغاء
                </x-filament::button>
            </div>
            @else
            {!! e(new \Illuminate\Support\HtmlString($this->comment?->body)) !!}
            @endif
        </div>

        <div class="flex flex-wrap items-center justify-start gap-2 md:space-x-reverse md:space-x-4">
            <x-filament::link size="xs" class="cursor-pointer" icon="heroicon-s-chat-bubble-left-right"
                wire:click.prevent="toggleReplies">
                @if($this->comment->replies_count > 0)
                <span title="{{ \Illuminate\Support\Number::format($this->comment->replies_count) }}">
                    {{ \Illuminate\Support\Number::forHumans($this->comment->replies_count, maxPrecision: 3, abbreviate:
                    true) }}
                    {{
                    str(__('nested-comments::nested-comments.comments.general.reply'))->plural($this->comment->replies_count)
                    }}
                </span>
                @else
                <span title="{{ __('nested-comments::nested-comments.comments.general.no_replies') }}">
                    {{ __('nested-comments::nested-comments.comments.form.buttons.reply') }}
                </span>
                @endif
            </x-filament::link>

            <livewire:nested-comments::reaction-panel :record="$this->comment" />
        </div>
    </div>

    @if($showReplies)
    <div x-ref="repliesContainer" class="relative pb-4 pr-8 my-2 border-b border-r rounded-br-xl">
        @foreach($this->comment->children as $reply)
        <livewire:nested-comments::comment-card :key="$reply->getKey()" :comment="$reply" />
        @endforeach

        <livewire:nested-comments::add-comment :key="$comment->getKey()" :commentable="$comment->commentable"
            :reply-to="$comment" :adding-comment="false" wire:loading.attr="disabled" />

        <x-filament::icon-button x-on:click="
                if ($refs.repliesContainer && $refs.repliesContainer.offsetHeight && $refs.repliesContainer.style.display !== 'none') {
                    const offset = $refs.repliesContainer.offsetHeight;
                    window.scrollBy({ top: -offset, behavior: 'smooth' });
                }" type="button"
            label="{{ __('nested-comments::nested-comments.comments.form.buttons.hide_replies') }}"
            tooltip="{{ __('nested-comments::nested-comments.comments.form.buttons.hide_replies') }}"
            icon="heroicon-o-minus-circle" class="absolute -right-8 -bottom-4" wire:click.prevent="toggleReplies" />
    </div>
    @endif
</div>

@script
<script>
    document.querySelectorAll('[data-mention-id]').forEach(element => {
        element.classList.add('comment-mention');
    });
</script>
@endscript