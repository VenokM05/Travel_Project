<?php

/**
 * Form Validation Test Script
 * 
 * This script tests all Form Request validation rules with invalid inputs.
 * Run this using: php test_validation.php
 * 
 * Note: This is a standalone test script. For production testing,
 * use Laravel's built-in testing with PHPUnit.
 */

echo "========================================\n";
echo "Form Validation Test Suite\n";
echo "========================================\n\n";

// Test cases for each Form Request
$testCases = [
    'StoreItineraryRequest' => [
        'valid' => [
            'title' => 'Paris Adventure',
            'destination' => 'Paris, France',
            'start_date' => '2024-12-01',
            'end_date' => '2024-12-10',
            'budget_total' => 5000,
            'status' => 'draft',
            'description' => 'A wonderful trip to Paris',
        ],
        'invalid' => [
            'Missing title' => [
                'destination' => 'Paris, France',
                'start_date' => '2024-12-01',
                'end_date' => '2024-12-10',
                'status' => 'draft',
            ],
            'End date before start date' => [
                'title' => 'Paris Adventure',
                'destination' => 'Paris, France',
                'start_date' => '2024-12-10',
                'end_date' => '2024-12-01',
                'status' => 'draft',
            ],
            'Negative budget' => [
                'title' => 'Paris Adventure',
                'destination' => 'Paris, France',
                'start_date' => '2024-12-01',
                'end_date' => '2024-12-10',
                'budget_total' => -100,
                'status' => 'draft',
            ],
            'Invalid status' => [
                'title' => 'Paris Adventure',
                'destination' => 'Paris, France',
                'start_date' => '2024-12-01',
                'end_date' => '2024-12-10',
                'status' => 'invalid_status',
            ],
            'Title too long (256 chars)' => [
                'title' => str_repeat('A', 256),
                'destination' => 'Paris, France',
                'start_date' => '2024-12-01',
                'end_date' => '2024-12-10',
                'status' => 'draft',
            ],
        ],
    ],

    'StoreBudgetRequest' => [
        'valid' => [
            'name' => 'Paris Trip Budget',
            'total_budget' => 5000,
            'currency' => 'USD',
            'type' => 'solo',
        ],
        'invalid' => [
            'Missing name' => [
                'total_budget' => 5000,
                'currency' => 'USD',
                'type' => 'solo',
            ],
            'Zero budget (valid)' => [
                'name' => 'Free Trip',
                'total_budget' => 0,
                'currency' => 'USD',
                'type' => 'solo',
            ],
            'Negative budget' => [
                'name' => 'Paris Trip Budget',
                'total_budget' => -100,
                'currency' => 'USD',
                'type' => 'solo',
            ],
            'Invalid currency (4 chars)' => [
                'name' => 'Paris Trip Budget',
                'total_budget' => 5000,
                'currency' => 'USDX',
                'type' => 'solo',
            ],
            'Invalid type' => [
                'name' => 'Paris Trip Budget',
                'total_budget' => 5000,
                'currency' => 'USD',
                'type' => 'invalid',
            ],
        ],
    ],

    'StoreExpenseRequest' => [
        'valid' => [
            'title' => 'Hotel Payment',
            'amount' => 150.50,
            'category' => 'Accommodation',
            'expense_date' => '2024-12-05',
        ],
        'invalid' => [
            'Missing title' => [
                'amount' => 150.50,
                'category' => 'Accommodation',
            ],
            'Negative amount' => [
                'title' => 'Hotel Payment',
                'amount' => -50,
                'category' => 'Accommodation',
            ],
            'Missing category' => [
                'title' => 'Hotel Payment',
                'amount' => 150.50,
            ],
            'Title too long' => [
                'title' => str_repeat('A', 256),
                'amount' => 150.50,
                'category' => 'Accommodation',
            ],
        ],
    ],

    'StoreTodoRequest' => [
        'valid' => [
            'title' => 'Book hotel',
            'priority' => 'high',
            'status' => 'pending',
            'due_date' => '2024-11-15',
        ],
        'invalid' => [
            'Missing title' => [
                'priority' => 'high',
                'status' => 'pending',
            ],
            'Invalid priority' => [
                'title' => 'Book hotel',
                'priority' => 'critical',
                'status' => 'pending',
            ],
            'Invalid status' => [
                'title' => 'Book hotel',
                'priority' => 'high',
                'status' => 'archived',
            ],
        ],
    ],

    'StoreMemoryRequest' => [
        'valid' => [
            'title' => 'Eiffel Tower Visit',
            'date' => '2024-12-05',
            'location' => 'Paris, France',
            'mood' => 'happy',
        ],
        'invalid' => [
            'Missing title' => [
                'date' => '2024-12-05',
                'location' => 'Paris, France',
            ],
            'Missing date' => [
                'title' => 'Eiffel Tower Visit',
                'location' => 'Paris, France',
            ],
            'Invalid date format' => [
                'title' => 'Eiffel Tower Visit',
                'date' => 'not-a-date',
            ],
        ],
    ],

    'StorePostRequest' => [
        'valid' => [
            'content' => 'Having an amazing time in Paris!',
            'privacy' => 'public',
            'location' => 'Eiffel Tower',
            'tags' => ['travel', 'paris', 'europe'],
        ],
        'invalid' => [
            'Missing content' => [
                'privacy' => 'public',
            ],
            'Content too long (2001 chars)' => [
                'content' => str_repeat('A', 2001),
            ],
            'Invalid privacy' => [
                'content' => 'Having an amazing time!',
                'privacy' => 'secret',
            ],
            'Invalid media URL' => [
                'content' => 'Check this photo',
                'media_urls' => ['not-a-url', 'also-not-url'],
            ],
            'Tag too long' => [
                'content' => 'Great post',
                'tags' => [str_repeat('tag', 17)], // 51 chars
            ],
        ],
    ],

    'StoreCommentRequest' => [
        'valid' => [
            'content' => 'Great post!',
        ],
        'invalid' => [
            'Missing content' => [],
            'Content too long (1001 chars)' => [
                'content' => str_repeat('A', 1001),
            ],
            'Invalid parent_id' => [
                'content' => 'Reply to comment',
                'parent_id' => 999999, // Non-existent
            ],
        ],
    ],
];

// Display test cases
foreach ($testCases as $requestName => $tests) {
    echo "\n" . str_repeat('-', 60) . "\n";
    echo "Testing: $requestName\n";
    echo str_repeat('-', 60) . "\n\n";

    // Valid case
    echo "✓ Valid Input:\n";
    foreach ($tests['valid'] as $key => $value) {
        $displayValue = is_string($value) && strlen($value) > 50 
            ? substr($value, 0, 50) . '...' 
            : $value;
        echo "  - $key: " . json_encode($displayValue) . "\n";
    }
    echo "\n";

    // Invalid cases
    echo "✗ Invalid Inputs (should fail validation):\n";
    $testNumber = 1;
    foreach ($tests['invalid'] as $testName => $invalidData) {
        echo "  $testNumber. $testName\n";
        foreach ($invalidData as $key => $value) {
            $displayValue = is_string($value) && strlen($value) > 50 
                ? substr($value, 0, 50) . '...' 
                : $value;
            echo "     - $key: " . json_encode($displayValue) . "\n";
        }
        $testNumber++;
    }
    echo "\n";
}

echo "\n========================================\n";
echo "Manual Testing Instructions\n";
echo "========================================\n\n";

echo "To test these validations in your browser:\n\n";

echo "1. Login to your application at http://127.0.0.1:8000\n\n";

echo "2. Test Itinerary Validation:\n";
echo "   - Go to: http://127.0.0.1:8000/itineraries/create\n";
echo "   - Try submitting with empty title\n";
echo "   - Try end_date before start_date\n";
echo "   - Try negative budget_total\n";
echo "   - Expected: Validation error messages displayed\n\n";

echo "3. Test Budget Validation:\n";
echo "   - Go to: http://127.0.0.1:8000/budgets/create\n";
echo "   - Try submitting with empty name\n";
echo "   - Try negative total_budget\n";
echo "   - Try invalid type (not 'solo' or 'group')\n";
echo "   - Expected: Validation error messages displayed\n\n";

echo "4. Test Todo Validation:\n";
echo "   - Go to: http://127.0.0.1:8000/todos/create\n";
echo "   - Try submitting with empty title\n";
echo "   - Try invalid priority (not low/medium/high/urgent)\n";
echo "   - Expected: Validation error messages displayed\n\n";

echo "5. Test Memory Validation:\n";
echo "   - Go to: http://127.0.0.1:8000/memories/create\n";
echo "   - Try submitting without title\n";
echo "   - Try invalid date format\n";
echo "   - Expected: Validation error messages displayed\n\n";

echo "6. Test Social Post Validation:\n";
echo "   - Go to: http://127.0.0.1:8000/social/wall\n";
echo "   - Try creating post with empty content\n";
echo "   - Try content longer than 2000 characters\n";
echo "   - Expected: Validation error messages displayed\n\n";

echo "7. Test Comment Validation:\n";
echo "   - Go to: http://127.0.0.1:8000/social/wall\n";
echo "   - Try commenting with empty content\n";
echo "   - Try comment longer than 1000 characters\n";
echo "   - Expected: Validation error messages displayed\n\n";

echo "========================================\n";
echo "Expected Validation Messages\n";
echo "========================================\n\n";

$expectedMessages = [
    'end_date.after_or_equal' => 'End date must be equal to or after start date',
    'budget_total.min' => 'Budget total must be zero or greater',
    'total_budget.min' => 'Total budget must be zero or greater',
    'priority.in' => 'Priority must be low, medium, high, or urgent',
    'status.in' => 'Status must be pending, in_progress, completed, or cancelled',
    'content.max' => 'Post content must not exceed 2000 characters',
    'privacy.in' => 'Privacy must be public, followers, or private',
];

foreach ($expectedMessages as $rule => $message) {
    echo "✓ $rule\n";
    echo "  → \"$message\"\n\n";
}

echo "\n========================================\n";
echo "Using Laravel Tinker for Testing\n";
echo "========================================\n\n";

echo "You can also test validation using Laravel Tinker:\n\n";
echo "php artisan tinker\n\n";
echo "Then run:\n";
echo "\$request = new \\App\\Http\\Requests\\StoreItineraryRequest();\n";
echo "\$request->merge(['title' => '', 'destination' => 'Paris']);\n";
echo "\$validator = \\Illuminate\\Support\\Facades\\Validator::make(\n";
echo "    \$request->all(),\n";
echo "    \$request->rules()\n";
echo ");\n";
echo "\$validator->errors()->all();\n\n";

echo "This will show you all validation errors.\n";
echo "\n========================================\n";
echo "Test Complete!\n";
echo "========================================\n";
