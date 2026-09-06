<?php

namespace App\Http\Controllers;

use App\Models\{Article,Book,BookableSlot,Course,DaughterMessage,Habit,HabitCompletion,MyRole,Song,Venture,WifeMessage};
use App\Support\RoleRepresentativeModels;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    public function __invoke(): View
    {
        $user = auth()->user() ?: User::query()->first();
        $roles = MyRole::query()
            ->where('user_id', $user?->id ?? 0)
            ->where('is_active', true)
            ->with('representativeModels')
            ->orderBy('sort_order')
            ->get()
            ->map(fn (MyRole $role) => $this->roleViewData($role, $user))
            ->values()
            ->all();

        return view('welcome', compact('roles'));
    }

    private function roleViewData(MyRole $role, ?User $user): array
    {
        // The role key is authoritative. Representative rows are metadata only,
        // so stale data can never make Human render Ventures, etc.
        $definitions = RoleRepresentativeModels::forRole($role->key);

        $representatives = collect($definitions)
            ->map(function (array $definition) use ($role, $user) {
                $stored = $role->representativeModels->first(
                    fn ($representative) => $representative->model_type === $definition['model']
                );

                return $this->representativeGroup(
                    $definition['model'],
                    $stored?->label ?: $definition['label'],
                    $stored?->template,
                    $user
                );
            })
            ->filter()
            ->values()
            ->all();

        $isRich = count($representatives) > 0;

        return [
            'key' => $role->key,
            'label' => $role->name,
            'article' => $role->article ?: 'a',
            'type' => $isRich ? 'rich' : 'simple',
            'preview' => $role->short_description ?: $role->description,
            'content' => $isRich ? null : ($role->description ?: $role->short_description),
            'title' => $role->description ?: $role->short_description,
            'description' => [],
            'groups' => $representatives,
        ];
    }

    private function representativeGroup(string $modelClass, ?string $label, ?string $template, ?User $user): ?array
    {
        $definition = RoleRepresentativeModels::definition($modelClass);

        if (! $user || ! $definition || ! is_a($modelClass, Model::class, true)) {
            return null;
        }

        $query = $modelClass::query()->where('user_id', $user->id);
        $defaultLabel = $definition['label'];

        if ($modelClass === Habit::class) {
            $from = Carbon::today()->subDays(55);
            $to = Carbon::today();
            $habits = $query->orderBy('name')->get();
            $completions = HabitCompletion::query()
                ->whereIn('habit_id', $habits->pluck('id'))
                ->whereBetween('completed_on', [$from->toDateString(), $to->toDateString()])
                ->get()
                ->groupBy('habit_id');

            $dates = collect(range(0, 55))->map(fn (int $offset) => $from->copy()->addDays($offset));
            $rows = $habits->map(function (Habit $habit) use ($dates, $completions) {
                $habitCompletions = $completions->get($habit->id, collect())->keyBy(fn ($completion) => $completion->completed_on->toDateString());
                $cells = $dates->map(function (Carbon $date) use ($habit, $habitCompletions) {
                    $scheduled = match ($habit->frequency) {
                        'weekly' => $date->dayOfWeek === $habit->start_date?->dayOfWeek,
                        'monthly' => $date->day === $habit->start_date?->day,
                        default => true,
                    };
                    if ($habit->start_date && $date->lt($habit->start_date)) $scheduled = false;
                    if ($habit->end_date && $date->gt($habit->end_date)) $scheduled = false;
                    return [
                        'date' => $date->toDateString(),
                        'completed' => $habitCompletions->has($date->toDateString()),
                        'scheduled' => $scheduled,
                    ];
                })->values()->all();
                return ['name' => $habit->name, 'frequency' => $habit->frequency, 'cells' => $cells];
            })->values()->all();

            return [
                'heading' => $label ?: $defaultLabel,
                'template' => $template,
                'type' => 'habit-grid',
                'dates' => $dates->map(fn (Carbon $date) => [
                    'date' => $date->toDateString(),
                    'label' => $date->format('D'),
                    'day' => $date->format('j'),
                    'month' => $date->format('M'),
                ])->values()->all(),
                'rows' => $rows,
            ];
        }

        if ($modelClass === BookableSlot::class) {
            $monday = Carbon::now()->startOfWeek(Carbon::MONDAY)->startOfDay();
            $friday = $monday->copy()->addDays(4)->endOfDay();
            $slots = $query->whereBetween('starts_at', [$monday, $friday])
                ->orderBy('starts_at')->get();
            $days = collect(range(0, 4))->map(fn (int $offset) => $monday->copy()->addDays($offset));
            $hours = collect(range(8, 17));
            $cells = [];
            foreach ($days as $day) {
                foreach ($hours as $hour) {
                    $start = $day->copy()->setTime($hour, 0);
                    $end = $start->copy()->addHour();
                    $slot = $slots->first(fn (BookableSlot $item) => $item->starts_at < $end && $item->ends_at > $start);
                    $cells[$day->toDateString()][$hour] = $slot ? [
                        'status' => $slot->status,
                        'type' => $slot->type,
                        'price' => $slot->price,
                        'start' => $slot->starts_at->format('H:i'),
                        'end' => $slot->ends_at->format('H:i'),
                    ] : null;
                }
            }

            return [
                'heading' => $label ?: $defaultLabel,
                'template' => $template,
                'type' => 'calendar',
                'week_label' => $monday->format('M j') . ' – ' . $friday->format('M j, Y'),
                'days' => $days->map(fn (Carbon $day) => [
                    'date' => $day->toDateString(),
                    'label' => $day->format('D'),
                    'number' => $day->format('j'),
                ])->values()->all(),
                'hours' => $hours->map(fn (int $hour) => sprintf('%02d:00', $hour))->all(),
                'cells' => $cells,
            ];
        }

        $items = match ($modelClass) {
            Venture::class => $query->orderByDesc('featured')->latest()->get()->map(fn (Venture $item) => [
                'name' => $item->name,
                'desc' => $item->description ?? '',
                'url' => $item->url ?: '#',
                'status' => $item->status,
                'type' => $item->type,
                'started' => $item->started_at?->format('M Y'),
                'ended' => $item->ended_at?->format('M Y'),
                'featured' => $item->featured,
            ]),
            Book::class => $query->latest()->get()->map(fn (Book $item) => [
                'name' => $item->title,
                'desc' => $item->description ?? '',
                'url' => $item->url ?: '#',
                'status' => $item->status,
                'subtitle' => $item->subtitle,
                'published' => $item->published_at?->format('Y'),
                'isbn' => $item->isbn,
                'cover' => $item->cover,
            ]),
            Article::class => $query->latest('published_at')->get()->map(fn (Article $item) => [
                'name' => $item->title,
                'desc' => $item->excerpt ?? '',
                'url' => $item->url ?: '#',
                'status' => $item->status,
                'publication' => $item->publication,
                'date' => $item->published_at?->format('M j, Y'),
            ]),
            Course::class => $query->latest()->get()->map(fn (Course $item) => [
                'name' => $item->title,
                'desc' => $item->description ?? '',
                'url' => '#',
                'status' => $item->status,
                'duration' => $item->duration,
                'price' => $item->price,
                'audience' => $item->audience,
                'image' => $item->image,
            ]),
            Song::class => $query->latest()->get()->map(fn (Song $item) => [
                'name' => $item->title,
                'desc' => $item->description ?? '',
                'url' => $item->audio ?: '#',
                'status' => $item->status,
                'date' => $item->written_at?->format('M j, Y'),
                'recording' => $item->recording,
                'cover' => $item->cover,
                'has_audio' => filled($item->audio),
            ]),
            WifeMessage::class => $query->latest('message_date')->get()->map(fn (WifeMessage $item) => [
                'name' => $item->title,
                'desc' => $item->message,
                'url' => '#',
                'type' => $item->type,
                'date' => $item->message_date?->format('M j, Y'),
                'year' => $item->message_date?->format('Y'),
            ]),
            DaughterMessage::class => $query->orderBy('age_at_time')->orderBy('message_date')->get()->map(fn (DaughterMessage $item) => [
                'name' => $item->title,
                'desc' => $item->message,
                'url' => '#',
                'occasion' => $item->occasion,
                'age' => $item->age_at_time,
                'date' => $item->message_date?->format('M j, Y'),
            ]),
            default => collect(),
        };

        return [
            'heading' => $label ?: $defaultLabel,
            'template' => $template,
            'type' => 'rich',
            'model_type' => $modelClass,
            'items' => $items->values()->all(),
        ];
    }
}
