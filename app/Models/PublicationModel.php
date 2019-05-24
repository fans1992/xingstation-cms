<?php

namespace App\Models;


/**
 * App\Models\PublicationModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Model ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|PublicationModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Model recent()
 * @mixin \Eloquent
 */
class PublicationModel extends Model
{
    protected $connection = 'publication';

}
