<?php

namespace App\Models;

use A17\Twill\Models\Model;
use Pboivin\TwillFormTemplates\HasFormTemplates;

class Item extends Model
{
    public $template;

    public $custom_template;

    use HasFormTemplates;
}
