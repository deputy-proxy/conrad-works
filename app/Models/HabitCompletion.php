<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class HabitCompletion extends Model { use HasFactory; protected $fillable=['habit_id','completed_on','notes']; protected function casts(): array{return ['completed_on'=>'date'];} public function habit(): BelongsTo{return $this->belongsTo(Habit::class);} }
