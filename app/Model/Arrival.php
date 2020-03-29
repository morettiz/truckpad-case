<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Arrival extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'drivers_name',
        'birth_date',
        'gender',
        'is_vehicle_owner',
        'is_truck_loaded',
        'drivers_license_category',
        'truck_id',
        'origin_lat',
        'origin_lng',
        'destination_lat',
        'destination_lng',
    ];

    protected $with = [
        'truck'
    ];

    protected $hidden = [
        'updated_at',
    ];

    protected $casts = [
        'birth_date' => 'date:d-m-Y',
        'created_at' => 'date:d-m-Y H:m:s',
        'origin_lat' => 'decimal:6',
        'origin_lng' => 'decimal:6',
        'destination_lat' => 'decimal:6',
        'destination_lng' => 'decimal:6',
        'is_vehicle_owner' => 'boolean',
        'is_truck_loaded' => 'boolean',
    ];

    public function truck()
    {
        return $this->belongsTo(Truck::class, 'truck_id', 'code');
    }

    public function scopeLoadedArrivalsBetween(Builder $builder, Carbon $from, Carbon $to)
    {
        return $builder
            ->where('is_truck_loaded', true)
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to);
    }

    public function scopeGetRoute(Builder $builder)
    {
        return $builder
            ->select(['origin_lat', 'origin_lng', 'destination_lat', 'destination_lng', 'truck_id']);
    }
}
