#!/bin/bash

# Script 4: Check for duplicate keys in hi/messages.php file
# This script finds duplicate array keys in the Hindi messages file

echo "🔍 Checking for duplicate keys in hi/messages.php..."
echo "==============================================="

HI_FILE="resources/lang/hi/messages.php"

# Check if file exists
if [ ! -f "$HI_FILE" ]; then
    echo "❌ Error: $HI_FILE not found!"
    exit 1
fi

echo "📁 Analyzing file: $HI_FILE"
echo ""

# Create temporary file
TEMP_FILE="temps/hi_keys.txt"

# Extract all keys from the PHP array (keys between quotes before '=>')
grep -o "'[^']*' *=>" "$HI_FILE" | \
    sed "s/'\\([^']*\\)' *=>.*/\\1/" | \
    sort > "$TEMP_FILE"

# Find duplicates
DUPLICATES=$(uniq -d < "$TEMP_FILE")

if [ -z "$DUPLICATES" ]; then
    echo "✅ No duplicate keys found in hi/messages.php!"
    TOTAL_KEYS=$(wc -l < "$TEMP_FILE")
    echo "📊 Total unique keys in hi/messages.php: $TOTAL_KEYS"
else
    echo "🚨 DUPLICATE KEYS FOUND:"
    echo "======================="
    echo "$DUPLICATES"
    echo ""
    
    # Show details for each duplicate
    echo "📋 Duplicate key details:"
    echo "========================"
    while IFS= read -r key; do
        if [ -n "$key" ]; then
            echo ""
            echo "Key: '$key'"
            grep -n "'$key' *=>" "$HI_FILE"
        fi
    done <<< "$DUPLICATES"
fi

# Files saved to temps/ directory for manual cleanup later
echo ""
echo "✅ Duplicate check complete!"