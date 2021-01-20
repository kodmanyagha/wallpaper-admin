<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property int remote_id
 * @property string name
 * @property string url
 * @property string created_at
 * @property string updated_at
 *
 * @author Emir Buğra Köksalan
 */
class Photographer extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
