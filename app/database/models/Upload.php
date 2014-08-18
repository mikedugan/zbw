<?php 

/**
 * Upload
 *
 * @property integer $id
 * @property integer $cid
 * @property boolean $parent_type_id
 * @property boolean $parent_id
 * @property string $name
 * @property string $description
 * @property string $location
 * @property integer $type
 * @property string $mime
 * @property integer $size
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Upload whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Upload whereCid($value)
 * @method static \Illuminate\Database\Query\Builder|\Upload whereParentTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\Upload whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\Upload whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Upload whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Upload whereLocation($value)
 * @method static \Illuminate\Database\Query\Builder|\Upload whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Upload whereMime($value)
 * @method static \Illuminate\Database\Query\Builder|\Upload whereSize($value)
 * @method static \Illuminate\Database\Query\Builder|\Upload whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Upload whereUpdatedAt($value)
 */
class Upload extends BaseModel
{
    protected $table = 'zbw_uploads';
    protected $guarded = ['location', 'name'];
}
