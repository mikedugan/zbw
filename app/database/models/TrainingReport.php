<?php 

/**
 * TrainingReport
 *
 * @property integer $id
 * @property integer $training_session_id
 * @property boolean $brief
 * @property boolean $runway
 * @property boolean $weather
 * @property boolean $coordination
 * @property boolean $flow
 * @property boolean $identity
 * @property boolean $separation
 * @property boolean $pointouts
 * @property boolean $airspace
 * @property boolean $loa
 * @property boolean $phraseology
 * @property boolean $priority
 * @property string $markups
 * @property string $markdown
 * @property string $reviewed
 * @property boolean $ots
 * @property integer $positive_points
 * @property integer $negative_points
 * @property float $modifier
 * @property-read \ControllerTraining $training
 * @method static \Illuminate\Database\Query\Builder|\TrainingReport whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingReport whereTrainingSessionId($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingReport whereBrief($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingReport whereRunway($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingReport whereWeather($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingReport whereCoordination($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingReport whereFlow($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingReport whereIdentity($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingReport whereSeparation($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingReport wherePointouts($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingReport whereAirspace($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingReport whereLoa($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingReport wherePhraseology($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingReport wherePriority($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingReport whereMarkups($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingReport whereMarkdown($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingReport whereReviewed($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingReport whereOts($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingReport wherePositivePoints($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingReport whereNegativePoints($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingReport whereModifier($value)
 */
class TrainingReport extends BaseModel
{
    protected $table = 'controller_training_reports';
    public $timestamps = false;
    static $rules = [
        'training_session_id' => 'integer',
        'brief' => 'integer|max:20',
        'runway' => 'integer|max:20',
        'weather' => 'integer|max:20',
        'coordination' => 'integer|max:20',
        'flow' => 'integer|max:20',
        'identity' => 'integer|max:20',
        'separation' => 'integer|max:20',
        'pointouts' => 'integer|max:20',
        'airspace' => 'integer|max:20',
        'loa' => 'integer|max:20',
        'phraseology' => 'integer|max:20',
        'priority' => 'integer|max:20',
        'markups' => '',
        'markdown' => '',
        'reviewed' => '',
        'ots' => 'integer',
        'positive_points' => 'integer',
        'negative_points' => 'integer',
        'modifier' => 'numeric'
    ];

    //relations
    public function training()
    {
        return $this->belongsTo('ControllerTraining', 'training_id', 'id');
    }
} 
