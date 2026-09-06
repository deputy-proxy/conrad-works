<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class MyRole extends Model {
    protected static function booted(): void
    {
        static::creating(function (self $model): void {
            if (blank($model->user_id)) {
                $model->user_id = auth()->id();
            }
        });
    }
 use HasFactory;
 protected $fillable=['user_id','key','name','article','short_description','description','type','icon','image','color','sort_order','is_active','is_featured'];
 protected function casts(): array { return ['is_active'=>'boolean','is_featured'=>'boolean']; }
 public function user(): BelongsTo { return $this->belongsTo(User::class); }
 public function representativeModels(): HasMany { return $this->hasMany(MyRoleRepresentative::class)->orderBy('sort_order'); }
}
