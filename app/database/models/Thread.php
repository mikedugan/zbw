<?php

/**
 * Thread
 *
 * @property integer $id
 * @property string $title
 * @property integer $user_id
 * @property integer $topics
 * @property boolean $has_attachments
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Thread whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Thread whereTitle($value) 
 * @method static \Illuminate\Database\Query\Builder|\Thread whereUserId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Thread whereTopics($value) 
 * @method static \Illuminate\Database\Query\Builder|\Thread whereHasAttachments($value) 
 * @method static \Illuminate\Database\Query\Builder|\Thread whereDeletedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Thread whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Thread whereUpdatedAt($value) 
 */
class Thread extends \Eloquent {
	protected $fillable = [];
}