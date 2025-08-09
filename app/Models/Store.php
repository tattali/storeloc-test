<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Store extends Model
{
    use HasFactory;

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_store');
    }


    public function scopeFilterByBoundsAndServices(Builder $query, array $bounds, array $serviceIds = [], string $operator = 'OR')
    {
        $query->whereBetween('lat', [$bounds['south'], $bounds['north']])
              ->whereBetween('lng', [$bounds['west'], $bounds['east']]);

        if (!empty($serviceIds)) {
            if ($operator === 'AND') {
                $query->whereHas('services', function ($q) use ($serviceIds) {
                    $q->whereIn('services.id', $serviceIds);
                }, '=', count($serviceIds));
            } else {
                $query->whereHas('services', function ($q) use ($serviceIds) {
                    $q->whereIn('services.id', $serviceIds);
                });
            }
        }

        return $query;
    }

}
