#!/bin/bash

# Script 3: Compare en/messages.php with bn/messages.php and show diff keys
# This script finds keys that exist in EN but missing in BN, and vice versa

echo "🔍 Comparing en/messages.php with bn/messages.php..."
echo "==================================================="

EN_FILE="resources/lang/en/messages.php"
BN_FILE="resources/lang/bn/messages.php"

# Check if files exist
if [ ! -f "$EN_FILE" ]; then
    echo "❌ Error: $EN_FILE not found!"
    exit 1
fi

if [ ! -f "$BN_FILE" ]; then
    echo "❌ Error: $BN_FILE not found!"
    exit 1
fi

echo "📁 Comparing files:"
echo "   English: $EN_FILE"
echo "   Bengali: $BN_FILE"
echo ""

# Create temporary files
EN_KEYS="temps/en_keys.txt"
BN_KEYS="temps/bn_keys.txt"
MISSING_IN_BN="temps/missing_in_bn.txt"
MISSING_IN_EN="temps/missing_in_en.txt"

# Extract keys from both files
grep -o "'[^']*' *=>" "$EN_FILE" | sed "s/'\\([^']*\\)' *=>.*/\\1/" | sort > "$EN_KEYS"
grep -o "'[^']*' *=>" "$BN_FILE" | sed "s/'\\([^']*\\)' *=>.*/\\1/" | sort > "$BN_KEYS"

# Find differences
comm -23 "$EN_KEYS" "$BN_KEYS" > "$MISSING_IN_BN"
comm -13 "$EN_KEYS" "$BN_KEYS" > "$MISSING_IN_EN"

# Count keys
EN_COUNT=$(wc -l < "$EN_KEYS")
BN_COUNT=$(wc -l < "$BN_KEYS")
MISSING_BN_COUNT=$(wc -l < "$MISSING_IN_BN")
MISSING_EN_COUNT=$(wc -l < "$MISSING_IN_EN")

echo "📊 Statistics:"
echo "=============="
echo "🇺🇸 English keys: $EN_COUNT"
echo "🇧🇩 Bengali keys: $BN_COUNT"
echo "🚨 Missing in Bengali: $MISSING_BN_COUNT"
echo "🚨 Missing in English: $MISSING_EN_COUNT"
echo ""

if [ "$MISSING_BN_COUNT" -gt 0 ]; then
    echo "🚨 Keys present in English but MISSING in Bengali:"
    echo "================================================="
    cat -n "$MISSING_IN_BN"
    echo ""
fi

if [ "$MISSING_EN_COUNT" -gt 0 ]; then
    echo "ℹ️  Keys present in Bengali but MISSING in English:"
    echo "================================================="
    cat -n "$MISSING_IN_EN"
    echo ""
fi

if [ "$MISSING_BN_COUNT" -eq 0 ] && [ "$MISSING_EN_COUNT" -eq 0 ]; then
    echo "✅ Perfect match! Both files have the same keys."
fi

# Calculate completion percentage
if [ "$EN_COUNT" -gt 0 ]; then
    COMPLETION=$((100 * (EN_COUNT - MISSING_BN_COUNT) / EN_COUNT))
    echo "📈 Bengali translation completion: $COMPLETION% ($((EN_COUNT - MISSING_BN_COUNT))/$EN_COUNT keys)"
fi

# Files saved to temps/ directory for manual cleanup later
echo ""
echo "✅ Comparison complete!"