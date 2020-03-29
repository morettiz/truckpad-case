<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArrivalFormRequest extends FormRequest
{
    const ACTION_STORE = 'store';
    const ACTION_UPDATE = 'update';
    const ACTION_COUNT = 'getLoadedTrucks';

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        switch (request()->route()->getActionMethod()) {
            case self::ACTION_STORE:
                return $this->onStore();
                break;
            case self::ACTION_UPDATE:
                return $this->onUpdate();
                break;
            case self::ACTION_COUNT:
                return $this->onLoadedTrucks();
                break;
            default:
                return [];
                break;
        }
    }

    private function onStore()
    {
        return [
            'drivers_name' => 'required',
            'birth_date' => 'required|date_format:Y-m-d',
            'gender' => [
                'required',
                Rule::in(['M', 'F']),
            ],
            'is_vehicle_owner' => 'required|boolean',
            'is_truck_loaded' => 'required|boolean',
            'drivers_license_category' => [
                'required',
                Rule::in(['D', 'E', 'AD', 'AE']),
            ],
            'truck_id' => 'required|exists:trucks,code',
            'origin_lat' => 'required|numeric',
            'origin_lng' => 'required|numeric',
            'destination_lat' => 'required|numeric',
            'destination_lng' => 'required|numeric',
        ];
    }

    private function onUpdate()
    {
        return [
            'drivers_name' => 'sometimes',
            'birth_date' => 'sometimes|date_format:Y-m-d',
            'gender' => [
                'sometimes',
                Rule::in(['M', 'F']),
            ],
            'is_vehicle_owner' => 'sometimes|boolean',
            'is_truck_loaded' => 'sometimes|boolean',
            'drivers_license_category' => [
                'sometimes',
                Rule::in(['D', 'E', 'AD', 'AE']),
            ],
            'truck_id' => 'sometimes|exists:trucks,code',
            'origin_lat' => 'sometimes|numeric',
            'origin_lng' => 'sometimes|numeric',
            'destination_lat' => 'sometimes|numeric',
            'destination_lng' => 'sometimes|numeric',
        ];
    }

    private function onLoadedTrucks()
    {
        return [
            'date' => 'sometimes|date_format:Y-m-d',
        ];
    }
}