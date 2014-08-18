<?php

/**
 * Comment
 *
 * @property integer $id
 * @property integer $author
 * @property string $content
 * @property integer $comment_type
 * @property integer $parent_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \User $user
 * @method static \Illuminate\Database\Query\Builder|\Comment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Comment whereAuthor($value)
 * @method static \Illuminate\Database\Query\Builder|\Comment whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\Comment whereCommentType($value)
 * @method static \Illuminate\Database\Query\Builder|\Comment whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Comment whereUpdatedAt($value)
 */
class Comment extends BaseModel {
    protected $guarded = ['author'];
    protected $table = 'zbw_comments';
    static $rules = [
        'author' => 'integer',
        'content' => 'required',
        'parent_id' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo('User', 'author', 'cid');
    }
}
