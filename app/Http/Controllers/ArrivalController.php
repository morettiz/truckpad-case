<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArrivalFormRequest;
use App\Model\Arrival;

class ArrivalController extends Controller
{
    public function index()
    {
        return response()->json(Arrival::all());
    }

    public function get($id)
    {
        return response()->json(Arrival::findOrFail($id));
    }

    public function store(ArrivalFormRequest $request)
    {
        return response()->json(Arrival::create($request->all()));
    }

    public function update($id, ArrivalFormRequest $request)
    {
        $arrival = Arrival::findOrFail($id);

        return response()->json($arrival->update($request->all()));
    }
}
