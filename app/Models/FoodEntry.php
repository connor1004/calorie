<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FoodEntry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'taken_at',
        'calorie',
        'price'
    ];

    /**
     * Get the food entries which this user took
     *
     * @return array
     */
    public function foodEntries()
    {
        return $this->hasMany(Channel::class, 'taken_by');
    }

    /**
     * Get the user that took the food entry.
     *
     * @return User
     */
    public function takenUser() {
        return $this->belongsTo(User::class, 'taken_by', 'id')->withTrashed();
    }
}
