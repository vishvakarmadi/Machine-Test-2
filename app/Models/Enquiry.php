<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enquiry extends Model
{
    protected $fillable = [
        'property_id',
        'name',
        'mobile',
        'email',
        'message',
    ];

    /**
     * Get the property that the enquiry is about.
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
