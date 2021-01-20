<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property int category_id
 * @property int photographer_id
 * @property int remote_id
 * @property int height
 * @property int width
 * @property string avg_color
 * @property string url
 * @property string original_url
 * @property string tiny_url
 * @property string created_at
 * @property string updated_at
 *
 * @author Emir Buğra Köksalan
 */
class Image extends Model
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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function photographer()
    {
        return $this->belongsTo(Photographer::class);
    }
}
