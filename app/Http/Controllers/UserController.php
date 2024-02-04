<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Log;
use App\Models\Unit;
use App\Models\User;
use App\Models\UserJabatan;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $filter = [];
        $dataResult = User::with('userJabatan.jabatan', 'unit')->when($request->q, function ($q) use ($request) {
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
        // Validasi unik untuk kolom username
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:7|max:16',
            'join_date' => 'required',
        ]);
        $dataJabatan = json_decode($request->jabatan);

        $unit = Unit::firstOrCreate(
            ['name' => $request->unit],
        );
        $newData = User::create([
            'unit_id' => $unit->id,
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'join_date' => $request->join_date,
        ]);
        foreach ($dataJabatan as $value) {
            $dataJabatan = Jabatan::firstOrCreate(
                ['name' => $value->name]
            );
            UserJabatan::create([
                "user_id" => $newData->id,
                "jabatan_id" => $dataJabatan->id,
            ]);
        }

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
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $pegawai)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $pegawai->id,
            'password' => 'required|min:7|max:16',
            'join_date' => 'required',
        ]);
        $unit = Unit::firstOrCreate(
            ['name' => $request->unit],
        );
        $jabatanIds = [];
        $pegawai->update([
            'unit_id' => $unit->id,
            'name' => $request->name,
            'username' => $request->username,
            'password' => $request->password != '' ? bcrypt($request->password) : $pegawai->password,
            'join_date' => $request->join_date,
        ]);
        $dataJabatan = json_decode($request->jabatan);

        foreach ($dataJabatan as $value) {
            $jabatan = Jabatan::firstOrCreate(['name' => $value->name]);
            $jabatanIds[] = $jabatan->id;

            UserJabatan::updateOrCreate(
                [
                    "user_id" =>  $pegawai->id,
                    "jabatan_id" => $jabatan->id,
                ],
                [
                    "user_id" =>  $pegawai->id,
                    "jabatan_id" => $jabatan->id,
                ]
            );
        }

        UserJabatan::where('user_id', $pegawai->id)->whereNotIn('jabatan_id', $jabatanIds)->delete();

        return response()->json([
            'statusCode'    => 200,
            'status'        => true,
            'message'       => 'Displaying data...',
            'data'          => $pegawai
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $pegawai)
    {
        Log::where('user_id', $pegawai->id)->delete();
        UserJabatan::where('user_id', $pegawai->id)->delete();
        $pegawai->delete();
        return response()->json([
            'statusCode'    => 200,
            'status'        => true,
            'message'       => 'Displaying data...',
            'data'          => $pegawai
        ]);
    }
}
