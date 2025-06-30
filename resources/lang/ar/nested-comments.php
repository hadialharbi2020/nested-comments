<?php

// translations for Hadialharbi/NestedComments
return [
    'comments' => [
        'general' => [
            'guest' => 'زائر',
            'no_comments_provided' => 'لا توجد تعليقات.',
            'no_commentable_record_set' => 'لم يتم تعيين سجل قابل للتعليق.',
            'record_is_not_configured_for_reactions' => 'السجل الحالي غير مهيأ للتفاعلات. يرجى تضمين الـ Trait المسمى `HasReactions` في النموذج.',
            'no_commentable_record_found_widget' => 'لم يتم العثور على سجل قابل للتعليق. يرجى تمرير سجل إلى الودجت.',
            'reply' => 'رد',
            'no_replies' => 'لا توجد ردود بعد.',
            'comments' => 'التعليقات',
        ],
        'form' => [
            'field' => [
                'comment' => [
                    'label' => 'تعليقك',
                    'mention_items_placeholder' => 'ابحث عن المستخدمين بالاسم أو البريد الإلكتروني',
                    'empty_mention_items_message' => 'لم يتم العثور على مستخدمين',
                ],
            ],
            'buttons' => [
                'submit' => 'إرسال',
                'cancel' => 'إلغاء',
                'add_comment' => 'إضافة تعليق جديد',
                'add_reply' => 'إضافة رد',
                'reply' => 'رد',
                'hide_replies' => 'إخفاء الردود',
                'refresh' => 'تحديث',
                'edit_comment' => 'تعديل التعليق',
                'save' => 'حفظ',
            ],
        ],
        'table' => [
            'actions' => [
                'view_comments' => [
                    // 'label' => 'عرض التعليق',
                    'heading' => 'التعليقات',
                    'close' => 'إغلاق',
                ],
            ],
        ],
        'actions' => [
            'view_comment' => [
                // 'label' => 'عرض التعليق',
                'heading' => 'عرض التعليقات',
                'close' => 'إغلاق',
            ],
        ],
    ],
    'reactions' => [
        'add_reaction' => 'أضف تفاعلًا',

        // يمكنك ترجمة الرموز التعبيرية (emoji) أيضًا إن رغبت

        '👍' => 'إعجاب',
        '👎' => 'عدم إعجاب',
        '❤️' => 'إعجاب قوي',
        '😂' => 'مضحك',
        '😮' => 'مندهش',
        '😢' => 'محزن',
        '💯' => 'ممتاز',
        '🔥' => 'ناري',
        '🎉' => 'احتفال',
        '🚀' => 'إطلاق',
    ],

];
