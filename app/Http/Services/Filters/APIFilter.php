<?php

namespace App\Http\Services\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Base class for filtering API results.
 */
class APIFilter {
    /**
     * Regex to transform `camelCase` notation to `snake_case`
     * (convention from JSON to database)
     * 
     * @var string
     */
    public static $parseRegex = "/(?<=\w)(?=[A-Z])|(?<=[a-z])(?=\d)/";

    /**
     * Supported parameters for use in queries.
     * 
     * @var array<string, array<string>>
     */
    protected $supported_parameters = [];

    /**
     * Operators supported by queries.
     * 
     * @var array<string, string>
     */
    protected $supported_operators = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
        'in' => 'in',
        'like' => 'like',
    ];

    /**
     * If query parameters name are different from field's name in database,
     * this array contains that conversion. Don't add conversions from `camelCase`
     * to `snake_case`; they are done automatically in `query_builder` function.
     * 
     * @var array<string, string>
     */
    protected $parameters_map = [];

    private function parseParameter(string $parameter) : string
    {
        $sn_param = preg_replace(APIFilter::$parseRegex, '_', $parameter);
        return strtolower($sn_param);
    }

    /**
     * API query builder. Add `where` calls to Eloquent query, for every valid
     * parameter and operator.
     * 
     * @param Illuminate\Http\Request $request Request from the API call.
     * @param Illuminate\Database\Eloquent\Builder &$elo_query
     * The query from Eloquent's model.
     * @param string $boolean logical operator for concatenation.
     */
    public function queryBuilder(Request $request, Builder &$elo_query, string $boolean = 'and') : void
    {
        foreach ($this->supported_parameters as $param => $ops) {
            $query = $request->query($param);
            if (!isset($query)) continue;

            $column_name = $this->parameters_map[$param] ?? $this->parseParameter($param);

            // If $query is a string, it's an equal operation,
            // else, if it's an array, read operations and apply them.
            switch (gettype($query)) {
                case 'string':
                    $elo_query->where($column_name, '=', $query, $boolean);
                    break;
                case 'array':
                    foreach ($ops as $op) {
                        if (!isset($query[$op]) || !isset($this->supported_operators[$op])) continue;
                        $elo_query->where($column_name, $op, $query[$op], $boolean);
                    }
                    break;
            }
        }
    }
}