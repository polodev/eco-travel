#!/bin/bash

# Script 4: Compare en/messages.php with hi/messages.php and show diff keys
# This script finds keys that exist in EN but missing in HI, and vice versa

echo "🔍 Comparing en/messages.php with hi/messages.php..."
echo "==================================================="

EN_FILE="resources/lang/en/messages.php"
HI_FILE="resources/lang/hi/messages.php"

# Check if files exist
if [ ! -f "$EN_FILE" ]; then
    echo "❌ Error: $EN_FILE not found!"
    exit 1
fi

if [ ! -f "$HI_FILE" ]; then
    echo "❌ Error: $HI_FILE not found!"
    exit 1
fi

echo "📁 Comparing files:"
echo "   English: $EN_FILE"
echo "   Hindi: $HI_FILE"
echo ""

# Create temporary files
EN_KEYS="temps/en_keys.txt"
HI_KEYS="temps/hi_keys.txt"
MISSING_IN_HI="temps/missing_in_hi.txt"
MISSING_IN_EN="temps/missing_in_en.txt"

# Extract keys from both files
grep -o "'[^']*' *=>" "$EN_FILE" | sed "s/'\\([^']*\\)' *=>.*/\\1/" | sort > "$EN_KEYS"
grep -o "'[^']*' *=>" "$HI_FILE" | sed "s/'\\([^']*\\)' *=>.*/\\1/" | sort > "$HI_KEYS"

# Find differences
comm -23 "$EN_KEYS" "$HI_KEYS" > "$MISSING_IN_HI"
comm -13 "$EN_KEYS" "$HI_KEYS" > "$MISSING_IN_EN"

# Count keys
EN_COUNT=$(wc -l < "$EN_KEYS")
HI_COUNT=$(wc -l < "$HI_KEYS")
MISSING_HI_COUNT=$(wc -l < "$MISSING_IN_HI")
MISSING_EN_COUNT=$(wc -l < "$MISSING_IN_EN")

echo "📊 Statistics:"
echo "=============="
echo "🇺🇸 English keys: $EN_COUNT"
echo "🇮🇳 Hindi keys: $HI_COUNT"
echo "🚨 Missing in Hindi: $MISSING_HI_COUNT"
echo "🚨 Missing in English: $MISSING_EN_COUNT"
echo ""

if [ "$MISSING_HI_COUNT" -gt 0 ]; then
    echo "🚨 Keys present in English but MISSING in Hindi:"
    echo "==============================================="
    cat -n "$MISSING_IN_HI"
    echo ""
fi

if [ "$MISSING_EN_COUNT" -gt 0 ]; then
    echo "ℹ️  Keys present in Hindi but MISSING in English:"
    echo "==============================================="
    cat -n "$MISSING_IN_EN"
    echo ""
fi

if [ "$MISSING_HI_COUNT" -eq 0 ] && [ "$MISSING_EN_COUNT" -eq 0 ]; then
    echo "✅ Perfect match! Both files have the same keys."
fi

# Calculate completion percentage
if [ "$EN_COUNT" -gt 0 ]; then
    COMPLETION=$((100 * (EN_COUNT - MISSING_HI_COUNT) / EN_COUNT))
    echo "📈 Hindi translation completion: $COMPLETION% ($((EN_COUNT - MISSING_HI_COUNT))/$EN_COUNT keys)"
fi

# Files saved to temps/ directory for manual cleanup later
echo ""
echo "✅ Comparison complete!"