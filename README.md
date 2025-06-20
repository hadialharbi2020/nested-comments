# 💬 التعليقات المتداخلة وردود الفعل باستخدام Filament (مع دعم اللغة العربية والـ RTL)

[![Packagist](https://img.shields.io/packagist/v/hadialharbi/nested-comments.svg?style=flat-square)](https://packagist.org/packages/hadialharbi/nested-comments)

هذه الحزمة مبنية على عمل رائع قام به [@coolsam726](https://github.com/coolsam726) في حزمته الأصلية [coolsam/nested-comments](https://github.com/coolsam726/nested-comments) — له كل الشكر والتقدير على هذا الأساس القوي والمتين. تم تطوير هذه النسخة لتدعم اللغة العربية والاتجاه من اليمين لليسار RTL، مع تحسينات على مستوى الواجهة والوظائف.

## ✅ الجديد في هذه النسخة

* ✅ دعم **اللغة العربية** والـ **RTL** بشكل كامل.
* ✅ دعم تعديل التعليقات مباشرة من خلال Livewire.
* ✅ دعم حذف التعليق.
* ✅ التحقق من صلاحية المستخدم قبل السماح بالتعديل أو الحذف.
* ✅ إرسال حدث `refresh` لتحديث الواجهة بعد حذف التعليق.
* ✅ تحسين تجربة المستخدم العربي بصريًا ونصيًا.
* ✅ دمج PHPUnit لاختبار الحزمة بكفاءة.

## ✅ دمج PHPUnit

تم إعداد اختبار الحزمة باستخدام [orchestra/testbench](https://github.com/orchestral/testbench):

* إعداد بيئة Laravel معزولة داخل `TestCase`.
* إنشاء قاعدة بيانات مؤقتة لتشغيل الاختبارات.
* اختبار أولي ناجح يتحقق من إنشاء تعليق.
* إصلاحات لمشاكل `migrations` و`macros`.

لتشغيل الاختبارات:

```bash
composer test
```

## التثبيت

```bash
composer require hadialharbi/nested-comments
```

ثم نفّذ الأمر التالي لتثبيت الحزمة:

```bash
php artisan nested-comments:install
```

واتبع التعليمات لنشر ملفات الإعدادات والمخططات.

## الاستخدام

1. أضف Trait `HasComments` إلى الموديل الذي ترغب بتعليقه عليه.
2. أضف Trait `HasReactions` إذا رغبت بدعم الإيموجي.
3. استخدم المكونات داخل Infolist أو Blade أو Livewire بكل سلاسة.

### Blade:

```blade
<x-nested-comments::comments :record="$post"/>
```

### Livewire:

```blade
<livewire:nested-comments::comments :record="$post" />
```

### ردود الفعل (الإيموجي)

```blade
<livewire:nested-comments::reaction-panel :record="$post" />
```

## التخصيص

يمكنك تعديل ملف الإعدادات `config/nested-comments.php` لتغيير:

* الأشكال والألوان.
* قائمة الإيموجي المسموحة.
* التحكم بالسماح للضيوف بالتفاعل.
* النصوص المعروضة في الواجهات.
* تحديد صلاحيات التعديل والحذف.
* التحكم في تنسيق التاريخ.

## الشكر

تم بناء هذه الحزمة على العمل الرائع من [coolsam/nested-comments](https://github.com/coolsam726/nested-comments) — شكرًا للمطور سام ماوسا على جهده وتفانيه في بناء أساس قوي لهذه الإضافة.
كما نعبر عن امتناننا لكل من ساهم في تطوير أدوات:

* FilamentPHP
* Laravel
* Livewire
* AlpineJS
* Laravel NestedSet
* Tiptap Editor

