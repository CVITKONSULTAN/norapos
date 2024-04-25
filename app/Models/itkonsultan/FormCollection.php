<?php

namespace App\Models\itkonsultan;

use Illuminate\Database\Eloquent\Model;

class FormCollection extends Model
{
    protected $fillable = [
        'form_slug',
        'data_input',
        'uid',
        'category',
        'ip',
    ];
}
