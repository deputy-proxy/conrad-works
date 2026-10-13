<?php

namespace Tests\Feature;

use App\Filament\Resources\ArticleResource;
use App\Filament\Resources\BookResource;
use App\Filament\Resources\BookableSlotResource;
use App\Filament\Resources\BookingResource;
use App\Filament\Resources\CourseResource;
use App\Filament\Resources\DaughterMessageResource;
use App\Filament\Resources\HabitCompletionResource;
use App\Filament\Resources\HabitResource;
use App\Filament\Resources\MyRoleResource;
use App\Filament\Resources\SongResource;
use App\Filament\Resources\VentureResource;
use App\Filament\Resources\WifeMessageResource;
use App\Models\Booking;
use App\Models\BookableSlot;
use App\Models\Habit;
use App\Models\HabitCompletion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class OwnedResourceAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_single_user_can_manage_records_with_any_legacy_owner_id(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $ownedHabit = $this->createHabit($owner, 'Owned habit');
        $foreignHabit = $this->createHabit($otherUser, 'Legacy habit');
        $ownedSlot = $this->createSlot($owner, '2026-10-14 10:00:00');
        $foreignSlot = $this->createSlot($otherUser, '2026-10-15 10:00:00');
        $ownedCompletion = HabitCompletion::query()->create([
            'habit_id' => $ownedHabit->id,
            'completed_on' => '2026-10-13',
        ]);
        $foreignCompletion = HabitCompletion::query()->create([
            'habit_id' => $foreignHabit->id,
            'completed_on' => '2026-10-13',
        ]);
        $ownedBooking = Booking::query()->create([
            'bookable_slot_id' => $ownedSlot->id,
            'name' => 'Owned booking',
            'email' => 'owned@example.test',
        ]);
        $foreignBooking = Booking::query()->create([
            'bookable_slot_id' => $foreignSlot->id,
            'name' => 'Legacy booking',
            'email' => 'legacy@example.test',
        ]);

        $gate = Gate::forUser($owner);

        foreach ([$ownedHabit, $foreignHabit, $ownedSlot, $foreignSlot, $ownedCompletion, $foreignCompletion, $ownedBooking, $foreignBooking] as $record) {
            $this->assertTrue($gate->allows('view', $record));
            $this->assertTrue($gate->allows('update', $record));
            $this->assertTrue($gate->allows('delete', $record));
        }
    }

    public function test_resource_queries_include_records_regardless_of_owner(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $ownedHabit = $this->createHabit($owner, 'Owned habit');
        $legacyHabit = $this->createHabit($otherUser, 'Legacy habit');
        $ownedSlot = $this->createSlot($owner, '2026-10-14 10:00:00');
        $legacySlot = $this->createSlot($otherUser, '2026-10-15 10:00:00');

        $ownedCompletion = HabitCompletion::query()->create([
            'habit_id' => $ownedHabit->id,
            'completed_on' => '2026-10-13',
        ]);
        $legacyCompletion = HabitCompletion::query()->create([
            'habit_id' => $legacyHabit->id,
            'completed_on' => '2026-10-13',
        ]);
        $ownedBooking = Booking::query()->create([
            'bookable_slot_id' => $ownedSlot->id,
            'name' => 'Owned booking',
            'email' => 'owned@example.test',
        ]);
        $legacyBooking = Booking::query()->create([
            'bookable_slot_id' => $legacySlot->id,
            'name' => 'Legacy booking',
            'email' => 'legacy@example.test',
        ]);

        $this->actingAs($owner);

        $this->assertEqualsCanonicalizing([$ownedHabit->id, $legacyHabit->id], HabitResource::getEloquentQuery()->pluck('id')->all());
        $this->assertEqualsCanonicalizing([$ownedCompletion->id, $legacyCompletion->id], HabitCompletionResource::getEloquentQuery()->pluck('id')->all());
        $this->assertEqualsCanonicalizing([$ownedSlot->id, $legacySlot->id], BookableSlotResource::getEloquentQuery()->pluck('id')->all());
        $this->assertEqualsCanonicalizing([$ownedBooking->id, $legacyBooking->id], BookingResource::getEloquentQuery()->pluck('id')->all());
    }

    public function test_all_model_resources_register_list_create_and_edit_pages(): void
    {
        foreach ([
            ArticleResource::class,
            BookResource::class,
            BookableSlotResource::class,
            BookingResource::class,
            CourseResource::class,
            DaughterMessageResource::class,
            HabitCompletionResource::class,
            HabitResource::class,
            MyRoleResource::class,
            SongResource::class,
            VentureResource::class,
            WifeMessageResource::class,
        ] as $resource) {
            $this->assertEqualsCanonicalizing(['index', 'create', 'edit'], array_keys($resource::getPages()), $resource);
        }
    }

    private function createHabit(User $owner, string $name): Habit
    {
        return Habit::query()->create([
            'user_id' => $owner->id,
            'name' => $name,
            'frequency' => 'daily',
        ]);
    }

    private function createSlot(User $owner, string $startsAt): BookableSlot
    {
        return BookableSlot::query()->create([
            'user_id' => $owner->id,
            'starts_at' => $startsAt,
            'ends_at' => date('Y-m-d H:i:s', strtotime($startsAt) + 3600),
            'status' => 'available',
        ]);
    }
}
