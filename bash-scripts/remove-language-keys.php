<?php

/**
 * Script to remove specific keys from language message files
 * Usage: php bash-scripts/remove-language-keys.php
 */

// Keys to be removed from all language files
$keysToRemove = [
    'flights',
    'hotels', 
    'holiday_packages',
    'hajj_packages',
    'eco_travel',
    'better_service_experience',
    'flight_booking',
    'about_us',
    'homepage_meta_description',
    'about_meta_description',
    'flight_meta_description',
    'hotel_meta_description',
    'holiday_package_meta_description',
    'hajj_package_meta_description',
    'search_hotels',
    'hotel_search',
    'find_perfect_accommodation',
    'destination',
    'enter_destination',
    'checkin_date',
    'checkout_date',
    'guests',
    'guest',
    'rooms',
    'room',
    'star_rating',
    'any_rating',
    'star',
    'stars',
    'searching',
    'searching_hotels',
    'hotel_results',
    'search_results',
    'showing_static_data',
    'powered_by',
    'no_hotels_found',
    'try_different_search',
    'new_search',
    'modify_search',
    'per_night',
    'view_details',
    'book_now',
    'featured',
    'star_hotel',
    'reviews',
    'more',
    'from_city_center',
    'from_airport',
    'hotel_details',
    'starting_from',
    'showing_static_data_details',
    'view_all_photos',
    'about_hotel',
    'amenities',
    'available_rooms',
    'hotel_policies',
    'check_times',
    'check_in',
    'check_out',
    'contact_info',
    'visit_website',
    'book_this_hotel',
    'search_other_hotels',
    'hotel_not_found',
    'hotel_not_available',
    'book_room',
    'search_flights',
    'flight_search',
    'find_best_flights',
    'departure_city',
    'arrival_city',
    'enter_departure_city',
    'enter_arrival_city',
    'departure_date',
    'return_date',
    'passengers',
    'passenger',
    'class',
    'economy',
    'business',
    'first_class',
    'searching_flights',
    'search_for',
    'flight_results',
    'no_flights_found',
    'per_person',
    'meal',
    'wifi',
    'entertainment',
    'flight_details',
    'departure_airport',
    'arrival_airport',
    'aircraft_information',
    'aircraft_type',
    'total_seats',
    'economy_seats',
    'business_seats',
    'first_class_seats',
    'flight_services',
    'meal_included',
    'no_meal',
    'wifi_available',
    'no_wifi',
    'entertainment_available',
    'no_entertainment',
    'baggage_allowance',
    'operating_days',
    'book_this_flight',
    'search_other_flights',
    'flight_not_found',
    'flight_not_available',
];

// Language directories to process
$languages = ['en', 'bn', 'es', 'hi'];
$baseDir = __DIR__ . '/../resources/lang';

// Statistics tracking
$stats = [
    'files_processed' => 0,
    'keys_removed_total' => 0,
    'keys_not_found' => [],
];

echo "🗑️  Starting removal of language keys...\n";
echo "📋 Keys to remove: " . count($keysToRemove) . "\n";
echo "🌐 Languages to process: " . implode(', ', $languages) . "\n\n";

foreach ($languages as $lang) {
    $filePath = $baseDir . '/' . $lang . '/messages.php';
    
    if (!file_exists($filePath)) {
        echo "⚠️  File not found: {$filePath}\n";
        continue;
    }
    
    echo "🔄 Processing {$lang}/messages.php...\n";
    
    // Read the file
    $content = file_get_contents($filePath);
    $originalContent = $content;
    
    // Load the array to check which keys exist
    $messages = include $filePath;
    if (!is_array($messages)) {
        echo "❌ Error: Could not load messages array from {$filePath}\n";
        continue;
    }
    
    $keysRemovedThisFile = 0;
    $keysNotFoundThisFile = [];
    
    foreach ($keysToRemove as $key) {
        if (!isset($messages[$key])) {
            $keysNotFoundThisFile[] = $key;
            continue;
        }
        
        // Remove the key using regex pattern
        // Pattern matches the key line including any comments and trailing comma
        $patterns = [
            // Pattern for key with single quotes and possible comment
            "/^(\s*)'{$key}'\s*=>\s*.*?(?:\/\/.*?)?(?:\n|\r\n)/m",
            // Pattern for key with double quotes and possible comment  
            "/^(\s*)\"{$key}\"\s*=>\s*.*?(?:\/\/.*?)?(?:\n|\r\n)/m",
            // Pattern for key without quotes and possible comment
            "/^(\s*){$key}\s*=>\s*.*?(?:\/\/.*?)?(?:\n|\r\n)/m",
        ];
        
        $removed = false;
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $content)) {
                $content = preg_replace($pattern, '', $content);
                $removed = true;
                $keysRemovedThisFile++;
                break;
            }
        }
        
        if (!$removed) {
            $keysNotFoundThisFile[] = $key;
        }
    }
    
    // Clean up any double empty lines that might have been created
    $content = preg_replace("/\n\s*\n\s*\n/", "\n\n", $content);
    
    // Only write if content changed
    if ($content !== $originalContent) {
        if (file_put_contents($filePath, $content) !== false) {
            echo "✅ Updated {$lang}/messages.php - Removed {$keysRemovedThisFile} keys\n";
            $stats['files_processed']++;
            $stats['keys_removed_total'] += $keysRemovedThisFile;
        } else {
            echo "❌ Error: Could not write to {$filePath}\n";
        }
    } else {
        echo "ℹ️  No changes needed for {$lang}/messages.php\n";
        $stats['files_processed']++;
    }
    
    // Track keys not found across all files
    foreach ($keysNotFoundThisFile as $key) {
        if (!in_array($key, $stats['keys_not_found'])) {
            $stats['keys_not_found'][] = $key;
        }
    }
    
    echo "\n";
}

// Display final statistics
echo "📊 REMOVAL COMPLETE!\n";
echo "==================\n";
echo "Files processed: {$stats['files_processed']}\n";
echo "Total keys removed: {$stats['keys_removed_total']}\n";

if (!empty($stats['keys_not_found'])) {
    echo "Keys not found in any file: " . count($stats['keys_not_found']) . "\n";
    echo "Missing keys: " . implode(', ', $stats['keys_not_found']) . "\n";
} else {
    echo "All specified keys were found and processed.\n";
}

echo "\n🎉 Language key removal completed successfully!\n";
echo "💡 Remember to test the application and commit the changes.\n";

?>