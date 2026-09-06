<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('my_role_representatives', function (Blueprint $table): void {
            $table->string('template')->nullable()->after('model_type');
        });

        $templates = [
            'App\\Models\\Habit' => 'habit-grid',
            'App\\Models\\WifeMessage' => 'letters',
            'App\\Models\\DaughterMessage' => 'life-timeline',
            'App\\Models\\BookableSlot' => 'calendar',
            'App\\Models\\Venture' => 'ventures',
            'App\\Models\\Book' => 'bookshelf',
            'App\\Models\\Article' => 'editorial-index',
            'App\\Models\\Course' => 'course-catalogue',
            'App\\Models\\Song' => 'track-library',
        ];

        foreach ($templates as $model => $template) {
            DB::table('my_role_representatives')
                ->where('model_type', $model)
                ->update(['template' => $template]);
        }
    }

    public function down(): void
    {
        Schema::table('my_role_representatives', function (Blueprint $table): void {
            $table->dropColumn('template');
        });
    }
};
