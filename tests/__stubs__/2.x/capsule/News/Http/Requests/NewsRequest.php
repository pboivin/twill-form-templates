<?php

namespace App\Twill\Capsules\News\Http\Requests;

use A17\Twill\Http\Requests\Admin\Request;

class NewsRequest extends Request
{
    public function rulesForCreate()
    {
        return [];
    }

    public function rulesForUpdate()
    {
        return [];
    }
}
