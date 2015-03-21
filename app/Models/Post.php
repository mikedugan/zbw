<?php

/**
 * Post
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $cid
 * @property integer $thread_id
 * @property integer $views
 * @property boolean $has_attachments
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Post whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Post whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Post whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\Post whereCid($value)
 * @method static \Illuminate\Database\Query\Builder|\Post whereThreadId($value)
 * @method static \Illuminate\Database\Query\Builder|\Post whereViews($value)
 * @method static \Illuminate\Database\Query\Builder|\Post whereHasAttachments($value)
 * @method static \Illuminate\Database\Query\Builder|\Post whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Post whereUpdatedAt($value)
 */
class Post extends \Eloquent {
	protected $fillable = [];
}