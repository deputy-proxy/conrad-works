<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class WifeMessage extends Model {
    protected static function booted(): void
    {
        static::creating(function (self $model): void {
            if (blank($model->user_id)) {
                $model->user_id = auth()->id();
            }
        });
    } use HasFactory; protected $fillable=['user_id','title','message','type','message_date','delivered_at']; protected function casts(): array{return ['message_date'=>'date','delivered_at'=>'datetime'];} public function user(): BelongsTo{return $this->belongsTo(User::class);} }
