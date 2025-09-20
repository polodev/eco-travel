#!/bin/bash

# Script 1: Extract all unique translation keys used in codebase and find missing keys in en/messages.php
# This script searches for __('messages.* patterns and compares with available keys

echo "🔍 Extracting translation keys and checking for missing ones..."
echo "============================================================="

EN_FILE="resources/lang/en/messages.php"

# Check if en/messages.php file exists
if [ ! -f "$EN_FILE" ]; then
    echo "❌ Error: $EN_FILE not found!"
    exit 1
fi

echo "📁 Analyzing files:"
echo "   Codebase: PHP and Blade files"
echo "   English messages: $EN_FILE"
echo ""

# Create temporary files
TEMP_USED_KEYS="temps/lang_keys_used.txt"
TEMP_EN_KEYS="temps/en_available_keys.txt"
TEMP_MISSING_KEYS="temps/missing_keys.txt"

# Search for all __('messages.* patterns in PHP and Blade files
# Extract the key name (part after 'messages.')
grep -r -h "__('messages\.[^']*'" . \
    --include="*.php" \
    --include="*.blade.php" \
    --exclude-dir=vendor \
    --exclude-dir=node_modules \
    --exclude-dir=storage \
    --exclude-dir=bootstrap/cache \
    -o | \
    sed "s/__('messages\.\([^']*\)'.*/\1/" | \
    sort | \
    uniq > "$TEMP_USED_KEYS"

# Extract keys from en/messages.php file
grep -o "'[^']*' *=>" "$EN_FILE" | sed "s/'\([^']*\)' *=>.*/\1/" | sort > "$TEMP_EN_KEYS"

# Find keys that are used in codebase but missing in en/messages.php
comm -23 "$TEMP_USED_KEYS" "$TEMP_EN_KEYS" > "$TEMP_MISSING_KEYS"

# Count keys
TOTAL_USED=$(wc -l < "$TEMP_USED_KEYS")
TOTAL_AVAILABLE=$(wc -l < "$TEMP_EN_KEYS")
TOTAL_MISSING=$(wc -l < "$TEMP_MISSING_KEYS")

echo "📊 Statistics:"
echo "=============="
echo "🔍 Keys used in codebase: $TOTAL_USED"
echo "📝 Keys available in en/messages.php: $TOTAL_AVAILABLE"
echo "🚨 Missing keys in en/messages.php: $TOTAL_MISSING"
echo ""

if [ "$TOTAL_MISSING" -gt 0 ]; then
    echo "🚨 Keys used in codebase but MISSING in en/messages.php:"
    echo "======================================================="
    cat -n "$TEMP_MISSING_KEYS"
    echo ""
else
    echo "✅ Perfect! All keys used in codebase are available in en/messages.php"
fi

# Files saved to temps/ directory for manual cleanup later
echo "✅ Analysis complete!"