<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ensure the votes table is empty before seeding
        DB::table('votes')->truncate();

        // Array to hold the vote data
        $votes = [];

        // Define the ranges for website IDs and user IDs
        $websiteIdRange = range(1, 24);
        $userIdRange = range(1, 11);

        // Seed a specific number of votes
        $numberOfVotes = 100; // You can adjust this number as needed

        for ($i = 0; $i < $numberOfVotes; $i++) {
            // Generate random website_id and user_id within the specified ranges
            $website_id = $websiteIdRange[array_rand($websiteIdRange)];
            $user_id = $userIdRange[array_rand($userIdRange)];

            // Add vote data to the array
            $votes[] = [
                'website_id' => $website_id,
                'user_id' => $user_id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert the votes into the votes table

        // Insert the votes into the votes table
        DB::table('votes')->insert($votes);
    }
}
