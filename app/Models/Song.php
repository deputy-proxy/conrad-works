<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Song extends Model {
    protected static function booted(): void
    {
        static::creating(function (self $model): void {
            if (blank($model->user_id)) {
                $model->user_id = auth()->id();
            }
        });
    } use HasFactory; protected $fillable=['user_id','title','lyrics','description','status','written_at','recording','audio','cover']; protected function casts(): array{return ['written_at'=>'date'];} public function user(): BelongsTo{return $this->belongsTo(User::class);} }
