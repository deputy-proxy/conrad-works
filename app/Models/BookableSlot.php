<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
class BookableSlot extends Model {
    protected static function booted(): void
    {
        static::creating(function (self $model): void {
            if (blank($model->user_id)) {
                $model->user_id = auth()->id();
            }
        });
    } use HasFactory; protected $fillable=['user_id','starts_at','ends_at','status','type','price']; protected function casts(): array{return ['starts_at'=>'datetime','ends_at'=>'datetime','price'=>'decimal:2'];} public function user(): BelongsTo{return $this->belongsTo(User::class);} public function booking(): HasOne{return $this->hasOne(Booking::class);} }
