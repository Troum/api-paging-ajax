<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static paginate(int $int)
 * @method static find(int $id)
 * @method static orderBy(string $string, string $string1)
 * @property mixed name
 */
class Tile extends Model
{
    use HasFactory;

    protected $fillable = [
      'name'
    ];

    protected $dates = [
      'created_at', 'updated_at'
    ];

    public function store($data)
    {
        $this->name = $data->name;
        $this->save();
    }
}
