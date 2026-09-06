<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Venture extends Model {
    protected static function booted(): void
    {
        static::creating(function (self $model): void {
            if (blank($model->user_id)) {
                $model->user_id = auth()->id();
            }
        });
    } use HasFactory; protected $fillable=['user_id','name','slug','description','url','status','type','started_at','ended_at','featured']; protected function casts(): array{return ['started_at'=>'date','ended_at'=>'date','featured'=>'boolean'];} public function user(): BelongsTo{return $this->belongsTo(User::class);} }
