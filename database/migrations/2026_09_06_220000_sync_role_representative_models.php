<?php

use App\Models\Article;
use App\Models\Book;
use App\Models\BookableSlot;
use App\Models\Course;
use App\Models\DaughterMessage;
use App\Models\Habit;
use App\Models\MyRole;
use App\Models\MyRoleRepresentative;
use App\Models\Song;
use App\Models\Venture;
use App\Models\WifeMessage;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('my_roles') || ! Schema::hasTable('my_role_representatives')) {
            return;
        }

        $user = User::query()->first();
        if (! $user) {
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
            $role = MyRole::query()->where('user_id', $user->id)->where('key', $key)->first();
            if (! $role) {
                continue;
            }

            MyRoleRepresentative::query()->where('my_role_id', $role->id)->delete();

            foreach ($representatives as $modelType => $label) {
                MyRoleRepresentative::query()->create([
                    'my_role_id' => $role->id,
                    'model_type' => $modelType,
                    'label' => $label,
                    'sort_order' => array_search($modelType, array_keys($representatives), true) + 1,
                    'is_primary' => array_key_first($representatives) === $modelType,
                    'configuration' => null,
                ]);
            }
        }
    }

    public function down(): void
    {
        // Data correction migration. The seeders remain the source of truth for demo data.
    }
};
