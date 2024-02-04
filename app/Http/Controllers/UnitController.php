<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = [];
        $dataResult = Unit::when($request->q, function ($q) use ($request) {
            $q->where('name', 'LIKE', '%' . $request->q . '%');
        })
            ->where($filter)
            ->orderBy($request->sort_by, $request->sort_order)
            ->paginate($request->per_page);

        return response()->json([
            'statusCode'    => 200,
            'status'        => true,
            'message'       => 'Displaying data...',
            'data'          => $dataResult
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $newData = Unit::create([
            "name" => $request->name
        ]);
        return response()->json([
            'statusCode'    => 200,
            'status'        => true,
            'message'       => 'Displaying data...',
            'data'          => $newData
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        $updatedData = $unit->update([
            "name" => $request->name
        ]);
        return response()->json([
            'statusCode'    => 200,
            'status'        => true,
            'message'       => 'Displaying data...',
            'data'          => $updatedData
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {

        $deletedData = $unit->delete();
        return response()->json([
            'statusCode'    => 200,
            'status'        => true,
            'message'       => 'Displaying data...',
            'data'          => $deletedData
        ]);
    }
}
