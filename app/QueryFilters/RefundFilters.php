<?php

namespace App\QueryFilters;

use Cerbero\QueryFilters\QueryFilters;

/**
 * Filter records based on query parameters.
 *
 */
class RefundFilters extends QueryFilters
{

    public function name($name)
    {
        $this->query->where('name', 'like', "%$name%");
    }

    public function email($email)
    {
        $this->query->where('email', 'like', "%$email%");
    }

    public function mobile($mobile)
    {
        $this->query->where('mobile', 'like', "%$mobile%");
    }
}
