<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
        });

        // Populate existing users with slugs
        \App\Models\User::chunk(100, function ($users) {
            foreach ($users as $user) {
                // Generate base slug
                $slug = \Illuminate\Support\Str::slug($user->name);
                if (empty($slug)) {
                    $slug = mb_substr(preg_replace('/\s+/', '-', trim($user->name)), 0, 80) . '-' . time();
                }

                // Ensure uniqueness
                $originalSlug = $slug;
                $counter = 1;
                while (\App\Models\User::where('slug', $slug)->where('id', '!=', $user->id)->exists()) {
                    $slug = $originalSlug . '-' . $counter++;
                }

                $user->slug = $slug;
                $user->saveQuietly(); // Use saveQuietly to prevent triggering events before boot logic is added
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
