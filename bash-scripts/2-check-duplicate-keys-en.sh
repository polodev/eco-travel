#!/bin/bash

# Script 2: Check for duplicate keys in en/messages.php file
# This script finds duplicate array keys in the English messages file

echo "🔍 Checking for duplicate keys in en/messages.php..."
echo "==================================================="

EN_FILE="resources/lang/en/messages.php"

# Check if file exists
if [ ! -f "$EN_FILE" ]; then
    echo "❌ Error: $EN_FILE not found!"
    exit 1
fi

echo "📁 Analyzing file: $EN_FILE"
echo ""

# Create temporary file
TEMP_FILE="temps/en_keys.txt"

# Extract all keys from the PHP array (keys between quotes before '=>')
grep -o "'[^']*' *=>" "$EN_FILE" | \
    sed "s/'\\([^']*\\)' *=>.*/\\1/" | \
    sort > "$TEMP_FILE"

# Find duplicates
DUPLICATES=$(uniq -d < "$TEMP_FILE")

if [ -z "$DUPLICATES" ]; then
    echo "✅ No duplicate keys found in en/messages.php!"
    TOTAL_KEYS=$(wc -l < "$TEMP_FILE")
    echo "📊 Total unique keys in en/messages.php: $TOTAL_KEYS"
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
            grep -n "'$key' *=>" "$EN_FILE"
        fi
    done <<< "$DUPLICATES"
fi

# Files saved to temps/ directory for manual cleanup later
echo ""
echo "✅ Duplicate check complete!"