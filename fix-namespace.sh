#!/bin/bash

PROJECT_DIR="/Users/hadialharbi/sites/packages/nested-comments"

echo "🔍 جاري تعديل namespace داخل ملفات المشروع..."

# تعديل namespace في مجلد src
find "$PROJECT_DIR/src" -type f -name "*.php" -exec sed -i '' 's/Coolsam\\NestedComments/Hadialharbi\\NestedComments/g' {} +

# تعديل namespace في مجلد factories
find "$PROJECT_DIR/database/factories" -type f -name "*.php" -exec sed -i '' 's/Coolsam\\NestedComments/Hadialharbi\\NestedComments/g' {} +

# تعديل namespace في مجلد tests
find "$PROJECT_DIR/tests" -type f -name "*.php" -exec sed -i '' 's/Coolsam\\NestedComments/Hadialharbi\\NestedComments/g' {} +

echo "✅ تم تعديل جميع ملفات namespace بنجاح!"
