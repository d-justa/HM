<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\RoomCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class MountainGalaxySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
public function run(): void
    {
        // 1. BEST PRACTICE: Idempotent Property Creation (Unique by subdomain)
        $property = Property::firstOrCreate(
            ['subdomain' => 'mg'], // Search criteria (unique column)
            ['name' => 'Mountain Galaxy'] // Creation data
        );

        // 2. Define data structure including the source room list
        $roomCategoriesData = [
            [
                'name' => 'Deluxe',
                // Keep the raw room list as part of the structure
                'rooms_list' => ['101', '102', '201', '202', '203', '204', '301', '302', '303', '304', '402']
            ],
            [
                'name' => 'Premium',
                'rooms_list' => [] // Still supported
            ],
            [
                'name' => 'Family Suite',
                'rooms_list' => ['401', '403']
            ],
        ];

        // 3. Define a generic timestamp to use for all records (required for bulk insert)
        $now = Carbon::now();

        // 4. MAIN LOOP: Manage unique categories through the relationship
        foreach ($roomCategoriesData as $categoryData) {
            // BEST PRACTICE & BUG FIX: Use firstOrCreate through the property relation.
            // This ensures uniqueness (category 'Deluxe' for property 'mg')
            // AND automatically sets category.property_id = $property->id.
            $category = $property->roomCategories()->firstOrCreate(
                ['name' => $categoryData['name']] // Unique by name FOR THIS PROPERTY
            );

            // OPTIMIZATION: Check if the category already has rooms.
            // If it does, and we are rerunning the seeder, skip room insertion.
            // This makes the seeder truly idempotent.
            if ($category->wasRecentlyCreated && !empty($categoryData['rooms_list'])) {

                // Define a placeholder array for bulk insertion
                $roomsToInsert = [];

                foreach ($categoryData['rooms_list'] as $roomName) {
                    // Populate the bulk insertion array.
                    // IMPORTANT: When doing bulk insert(), you MUST manually supply timestamps.
                    $roomsToInsert[] = [
                        'name' => $roomName,
                        'room_category_id' => $category->id,
                        // Set timestamps manually for the bulk insert
                        'created_at' => $now,
                        'updated_at' => $now,
                        'property_id' => $property->id
                    ];
                }

                // OPTIMIZATION: Bulk Insertion.
                // This single query inserts all 11 Deluxe rooms (or 2 Family Suite rooms).
                // It is hundreds of times faster than 11 separate create() calls.
                $category->rooms()->insert($roomsToInsert);
            }
        }
    }
}