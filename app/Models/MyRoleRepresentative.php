<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class MyRoleRepresentative extends Model {
 use HasFactory;
 protected $fillable=['my_role_id','model_type','label','icon','sort_order','is_primary','configuration'];
 protected function casts(): array { return ['is_primary'=>'boolean','configuration'=>'array']; }
 public function myRole(): BelongsTo { return $this->belongsTo(MyRole::class); }
 public function modelClass(): string { return $this->model_type; }
}
