<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $data)
 * @method static latest()
 * @method static findOrFail(int $id)
 * @method static where(string $string, mixed $location)
 */
class Banner extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function admin()
    {
        return $this->belongsTo(User::class, 'updated_by')->select('id', 'name');
    }
}
