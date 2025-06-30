<div dir="rtl" class="text-right">

    @if ($comment)
        <div class="p-8 my-4 rounded-lg bg-gray-50 ring-gray-100 dark:bg-gray-950" x-data="{ isDeleted: false }"
            x-show="!isDeleted" x-transition.opacity>
            <div class="flex flex-wrap items-center justify-between rtl:space-x-reverse">
                <div class="flex items-center gap-2 rtl:flex-row">
                    <x-filament::avatar :src="$this->getAvatar()" :alt="$this->getCommentator()" :name="$this->getCommentator()" size="md"
                        :circular="false" />
                    <div x-on:mouseover="showFullDate = true" x-on:mouseout="showFullDate = false"
                        class="text-right cursor-pointer rtl:text-right">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                            {{ $this->getCommentator() }}
                        </p>
                        <p x-show="!showFullDate" class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $this->comment->created_at?->diffForHumans() }}
                        </p>
                        <p x-show="showFullDate" class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $this->comment->created_at->format(config('nested-comments.format-created-date', 'F j Y h:i:s A')) }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="my-4 prose max-w-none dark:prose-invert">
                {!! e(new \Illuminate\Support\HtmlString($this->comment?->body)) !!}
            </div>

            <div class="flex flex-wrap items-center gap-2 md:space-x-4">
                <livewire:nested-comments::edit-comment :comment="$this->comment" :key="'edit-' . $this->comment->getKey()" />
                <x-filament::icon-button icon="heroicon-o-trash" size="xs" color="danger"
                    wire:confirm="هل أنت متأكد من حذف التعليق؟" wire:click="deleteComment" tooltip="حذف التعليق"
                    x-on:click="isDeleted = true" />


                <x-filament::link size="xs" class="cursor-pointer" icon="heroicon-s-chat-bubble-left-right"
                    wire:click.prevent="toggleReplies">
                    @if ($this->comment && $this->comment->replies_count > 0)
                        <span title="{{ \Illuminate\Support\Number::format($this->comment->replies_count) }}">
                            {{ \Illuminate\Support\Number::forHumans($this->comment->replies_count, maxPrecision: 3, abbreviate: true) }}
                            {{ str(__('nested-comments::nested-comments.comments.general.reply'))->plural($this->comment->replies_count) }}
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

        @if ($replyingToCommentId === $comment->id && $this->comment->replies_count)
            <div x-ref="repliesContainer" class="pb-4 pr-8 my-2 border-b border-r rounded-br-xl">
                @foreach ($this->comment->children as $reply)
                    <livewire:nested-comments::comment-card :key="$reply->getKey()" :comment="$reply" />
                @endforeach

                @if (auth()->check() ? auth()->user()->hasPermissionTo('create comments') : true)
                    <livewire:nested-comments::add-comment :key="'reply-' . $comment->getKey()" :commentable="$comment->commentable" :reply-to="$comment"
                        :adding-comment="false" wire:loading.attr="disabled" />
                @endif

                <x-filament::icon-button
                    x-on:click="
                    if ($refs.repliesContainer && $refs.repliesContainer.offsetHeight && $refs.repliesContainer.style.display !== 'none') {
                        const offset = $refs.repliesContainer.offsetHeight;
                        window.scrollBy({ top: -offset, behavior: 'smooth' });
                    }
                    "
                    type="button"
                    label="{{ __('nested-comments::nested-comments.comments.form.buttons.hide_replies') }}"
                    tooltip="{{ __('nested-comments::nested-comments.comments.form.buttons.hide_replies') }}"
                    icon="heroicon-o-minus-circle" class="absolute -left-8 -bottom-4"
                    wire:click.prevent="toggleReplies" />
            </div>
        @endif
    @else
        <div class="p-8 my-4 rounded-lg opacity-50 bg-gray-50 ring-gray-100 dark:bg-gray-950" x-data="{ isDeleted: true }"
            x-show="isDeleted" x-transition.opacity>
            <p class="text-gray-500 dark:text-gray-400">
                {{ __('nested-comments::nested-comments.comments.general.deleted') }}</p>
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
