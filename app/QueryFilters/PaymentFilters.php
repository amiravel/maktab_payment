<?php

namespace App\QueryFilters;

use Cerbero\QueryFilters\QueryFilters;

/**
 * Filter records based on query parameters.
 *
 */
class PaymentFilters extends QueryFilters
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

    public function statuses($statuses)
    {
        $this->query->scopes($statuses);
    }

    public function tags($tags)
    {
        $this->query->whereHas('tags', function ($query) use ($tags) {
            $query->whereIn('id', $tags);
        });
    }

    public function drive($drive)
    {
        $this->query->scopes([
            'drive' => $drive
        ]);
    }

    public function from($date)
    {
        $this->query->whereDate('created_at', '>=', $date);
    }

    public function to($date)
    {
        $this->query->whereDate('created_at', '<=', $date);
    }
}
