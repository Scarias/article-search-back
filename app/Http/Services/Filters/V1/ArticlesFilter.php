<?php

namespace App\Http\Services\Filters\V1;

use App\Http\Services\Filters\APIFilter;

/**
 * A APIFilter for the Article model.
 */
class ArticlesFilter extends APIFilter {
    protected $supported_parameters = [
        'title' => ['eq', 'like'],
        'content' => ['eq', 'like'],
        'createdBy' => ['eq'],
    ];

    protected $parameters_map = [
        'createdBy' => 'user_id',
    ];
}
