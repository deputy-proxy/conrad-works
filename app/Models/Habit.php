<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Habit extends Model {
    protected static function booted(): void
    {
        static::creating(function (self $model): void {
            if (blank($model->user_id)) {
                $model->user_id = auth()->id();
            }
        });
    } use HasFactory; protected $fillable=['user_id','name','description','frequency','target','start_date','end_date','active']; protected function casts(): array { return ['start_date'=>'date','end_date'=>'date','active'=>'boolean']; } public function user(): BelongsTo{return $this->belongsTo(User::class);} public function completions(): HasMany{return $this->hasMany(HabitCompletion::class);} }
