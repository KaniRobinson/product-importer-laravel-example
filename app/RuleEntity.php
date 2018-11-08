<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RuleEntity extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rule_entities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rule_id', 'value', 'index',
    ];

    /**
     * Rule Belongs To Relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rule() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this
            ->belongsTo(
                \App\Rule::class,
                'rule_id'
            );
    }
}
