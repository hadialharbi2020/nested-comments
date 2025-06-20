<?php

return [

    'tables' => [
        'comments' => 'comments',
        'reactions' => 'reactions',
        'users' => 'users',
    ],

    'models' => [
        'comment' => Hadialharbi\NestedComments\Models\Comment::class,
        'reaction' => Hadialharbi\NestedComments\Models\Reaction::class,
        'user' => env('AUTH_MODEL', App\Models\User::class),
    ],

    'policies' => [
        'comment' => null,
        'reaction' => null,
    ],

    'allowed-reactions' => [
        '👍' => __('nested-comments::nested-comments.reactions.thumbs_up'),
        '👎' => __('nested-comments::nested-comments.reactions.thumbs_down'),
        '❤️' => __('nested-comments::nested-comments.reactions.heart'),
        '😂' => __('nested-comments::nested-comments.reactions.laughing'),
        '😮' => __('nested-comments::nested-comments.reactions.surprised'),
        '😢' => __('nested-comments::nested-comments.reactions.crying'),
        '💯' => __('nested-comments::nested-comments.reactions.hundred_points'),
        '🔥' => __('nested-comments::nested-comments.reactions.fire'),
        '🎉' => __('nested-comments::nested-comments.reactions.party_popper'),
        '🚀' => __('nested-comments::nested-comments.reactions.rocket'),
    ],

    'allow-all-reactions' => env('ALLOW_ALL_REACTIONS', false),
    'allow-multiple-reactions' => env('ALLOW_MULTIPLE_REACTIONS', false),
    'allow-guest-reactions' => env('ALLOW_GUEST_REACTIONS', false),
    'allow-guest-comments' => env('ALLOW_GUEST_COMMENTS', false),

    'format-created-date' => 'F j Y h:i:s A',

    'show-heading' => true,
    'show-badge-counter' => true,
    'badge-counter-color' => 'info',

    'show-refresh-button' => true,
    'style-refresh-button' => 'button',
    'icon-refresh-button' => 'heroicon-m-sparkles',
    'outlined-refresh-button' => false,
    'color-refresh-button' => 'info',

    // 🆕 إضافات مقترحة مستقبلًا:
    'enable_rtl' => true,

    'ui' => [
        'show_user_avatar' => true,
        'show_datetime_tooltip' => true,
    ],

    'permissions' => [
        'can_edit_comment' => true,
        'can_delete_comment' => true,
    ],
];
