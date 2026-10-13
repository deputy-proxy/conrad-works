<?php

namespace Tests\Feature;

use App\Filament\Resources\BookingResource;
use App\Filament\Resources\BookableSlotResource;
use App\Filament\Resources\HabitCompletionResource;
use App\Filament\Resources\HabitResource;
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

    public function test_policy_allows_only_the_owner_to_view_update_or_delete_records(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $ownedHabit = $this->createHabit($owner, 'Owned habit');
        $foreignHabit = $this->createHabit($otherUser, 'Foreign habit');
        $ownedSlot = $this->createSlot($owner);
        $foreignSlot = $this->createSlot($otherUser);
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
            'name' => 'Foreign booking',
            'email' => 'foreign@example.test',
        ]);

        $gate = Gate::forUser($owner);

        $this->assertTrue($gate->allows('view', $ownedHabit));
        $this->assertTrue($gate->allows('update', $ownedSlot));
        $this->assertTrue($gate->allows('delete', $ownedCompletion));
        $this->assertTrue($gate->allows('view', $ownedBooking));

        $this->assertFalse($gate->allows('view', $foreignHabit));
        $this->assertFalse($gate->allows('update', $foreignSlot));
        $this->assertFalse($gate->allows('delete', $foreignCompletion));
        $this->assertFalse($gate->allows('view', $foreignBooking));
    }

    public function test_resource_queries_scope_primary_and_child_records_to_the_owner(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $ownedHabit = $this->createHabit($owner, 'Owned habit');
        $foreignHabit = $this->createHabit($otherUser, 'Foreign habit');
        $ownedSlot = $this->createSlot($owner);
        $foreignSlot = $this->createSlot($otherUser);

        $ownedCompletion = HabitCompletion::query()->create([
            'habit_id' => $ownedHabit->id,
            'completed_on' => '2026-10-13',
        ]);
        HabitCompletion::query()->create([
            'habit_id' => $foreignHabit->id,
            'completed_on' => '2026-10-13',
        ]);
        $ownedBooking = Booking::query()->create([
            'bookable_slot_id' => $ownedSlot->id,
            'name' => 'Owned booking',
            'email' => 'owned@example.test',
        ]);
        Booking::query()->create([
            'bookable_slot_id' => $foreignSlot->id,
            'name' => 'Foreign booking',
            'email' => 'foreign@example.test',
        ]);

        $this->actingAs($owner);

        $this->assertSame([$ownedHabit->id], HabitResource::getEloquentQuery()->pluck('id')->all());
        $this->assertSame([$ownedCompletion->id], HabitCompletionResource::getEloquentQuery()->pluck('id')->all());
        $this->assertSame([$ownedSlot->id], BookableSlotResource::getEloquentQuery()->pluck('id')->all());
        $this->assertSame([$ownedBooking->id], BookingResource::getEloquentQuery()->pluck('id')->all());
    }

    private function createHabit(User $owner, string $name): Habit
    {
        return Habit::query()->create([
            'user_id' => $owner->id,
            'name' => $name,
            'frequency' => 'daily',
        ]);
    }

    private function createSlot(User $owner): BookableSlot
    {
        return BookableSlot::query()->create([
            'user_id' => $owner->id,
            'starts_at' => '2026-10-14 10:00:00',
            'ends_at' => '2026-10-14 11:00:00',
            'status' => 'available',
        ]);
    }
}
