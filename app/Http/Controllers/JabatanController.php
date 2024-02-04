<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Http\Requests\StoreJabatanRequest;
use App\Http\Requests\UpdateJabatanRequest;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = [];
        $dataResult = Jabatan::when($request->q, function ($q) use ($request) {
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
        $newData = Jabatan::create([
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
    public function show(Jabatan $jabatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jabatan $jabatan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jabatan $jabatan)
    {
        $updatedData = $jabatan->update([
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
    public function destroy(Jabatan $jabatan)
    {

        $deletedData = $jabatan->delete();
        return response()->json([
            'statusCode'    => 200,
            'status'        => true,
            'message'       => 'Displaying data...',
            'data'          => $deletedData
        ]);
    }
}
