<?php

use App\Models\Article;
use App\Models\Book;
use App\Models\BookableSlot;
use App\Models\Course;
use App\Models\DaughterMessage;
use App\Models\Habit;
use App\Models\MyRoleRepresentative;
use App\Models\Song;
use App\Models\Venture;
use App\Models\WifeMessage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('my_roles') || ! Schema::hasTable('my_role_representatives')) {
            return;
        }

        $map = [
            'human' => [Habit::class => 'Habits'],
            'husband' => [WifeMessage::class => 'Wife Messages'],
            'father' => [DaughterMessage::class => 'Daughter Messages'],
            'consultant' => [BookableSlot::class => 'Bookable Slots'],
            'entrepreneur' => [Venture::class => 'Ventures'],
            'writer' => [Book::class => 'Books', Article::class => 'Articles'],
            'trainer' => [Course::class => 'Courses'],
            'songwriter' => [Song::class => 'Songs'],
        ];

        foreach ($map as $key => $representatives) {
            $roles = \App\Models\MyRole::query()->where('key', $key)->get();

            foreach ($roles as $role) {
                MyRoleRepresentative::query()->where('my_role_id', $role->id)->delete();

                foreach (array_keys($representatives) as $sort => $modelType) {
                    MyRoleRepresentative::query()->create([
                        'my_role_id' => $role->id,
                        'model_type' => $modelType,
                        'label' => $representatives[$modelType],
                        'sort_order' => $sort + 1,
                        'is_primary' => $sort === 0,
                        'configuration' => null,
                    ]);
                }
            }
        }
    }

    public function down(): void
    {
        // Intentional data normalization. The authoritative role/model contract
        // remains defined in App\Support\RoleRepresentativeModels.
    }
};
