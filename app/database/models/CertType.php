<?php

use Robbo\Presenter\PresentableInterface;
use Zbw\Training\Presenters\CertificationPresenter;

/**
 * CertType
 *
 * @property integer $id
 * @property string $value
 * @method static \Illuminate\Database\Query\Builder|\CertType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\CertType whereValue($value)
 */
class CertType extends BaseModel implements PresentableInterface
{
    protected $fillable = ['value'];
    protected $table = '_cert_types';
    public $timestamps = false;
    static $rules = [
        'value' => 'required'
    ];

    public function getPresenter()
    {
        return new CertificationPresenter($this);
    }
}
