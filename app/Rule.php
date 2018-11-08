<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rules';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Rule Entity Has Many Relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ruleEntities() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this
            ->hasMany(
                \App\RuleEntity::class,
                'rule_id'
            )->orderBy('index');
    }
}
