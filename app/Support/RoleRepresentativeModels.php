<?php
namespace App\Support;
use App\Models\{Article,Book,BookableSlot,Course,DaughterMessage,Habit,Song,Venture,WifeMessage};
final class RoleRepresentativeModels {
 public static function options(): array { return [Habit::class=>'Habits',WifeMessage::class=>'Wife Messages',DaughterMessage::class=>'Daughter Messages',BookableSlot::class=>'Bookable Slots',Venture::class=>'Ventures',Book::class=>'Books',Article::class=>'Articles',Course::class=>'Courses',Song::class=>'Songs']; }
}
