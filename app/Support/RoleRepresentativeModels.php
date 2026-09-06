<?php

namespace App\Support;

use App\Models\{Article, Book, BookableSlot, Course, DaughterMessage, Habit, Song, Venture, WifeMessage};

final class RoleRepresentativeModels
{
    /**
     * The visual/domain contract for every role. The role key is authoritative;
     * database representative rows provide the presentation template, label, order and configuration.
     */
    public static function roles(): array
    {
        return [
            'human' => [
                ['model' => Habit::class, 'label' => 'Habits'],
            ],
            'husband' => [
                ['model' => WifeMessage::class, 'label' => 'Wife Messages'],
            ],
            'father' => [
                ['model' => DaughterMessage::class, 'label' => 'Daughter Messages'],
            ],
            'consultant' => [
                ['model' => BookableSlot::class, 'label' => 'Bookable Slots'],
            ],
            'entrepreneur' => [
                ['model' => Venture::class, 'label' => 'Ventures'],
            ],
            'writer' => [
                ['model' => Book::class, 'label' => 'Books'],
                ['model' => Article::class, 'label' => 'Articles'],
            ],
            'trainer' => [
                ['model' => Course::class, 'label' => 'Courses'],
            ],
            'songwriter' => [
                ['model' => Song::class, 'label' => 'Songs'],
            ],
        ];
    }

    public static function forRole(string $roleKey): array
    {
        return self::roles()[$roleKey] ?? [];
    }

    public static function definition(string $modelClass): ?array
    {
        foreach (self::roles() as $definitions) {
            foreach ($definitions as $definition) {
                if ($definition['model'] === $modelClass) {
                    return $definition;
                }
            }
        }

        return null;
    }

    public static function options(): array
    {
        $options = [];

        foreach (self::roles() as $definitions) {
            foreach ($definitions as $definition) {
                $options[$definition['model']] = $definition['label'];
            }
        }

        return $options;
    }
}
