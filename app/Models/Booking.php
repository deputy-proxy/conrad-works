<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Booking extends Model { use HasFactory; protected $fillable=['bookable_slot_id','name','email','notes','status','booked_at']; protected function casts(): array{return ['booked_at'=>'datetime'];} public function bookableSlot(): BelongsTo{return $this->belongsTo(BookableSlot::class);} }
