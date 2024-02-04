<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Log;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function totalPerItem(Request $request)
    {

        $commonQuery = function ($query) use ($request) {
            if ($request->rentang_tanggal && count($request->rentang_tanggal) == 2) {
                $startDate = date('Y-m-d', strtotime($request->rentang_tanggal[0]));
                $endDate = date('Y-m-d', strtotime($request->rentang_tanggal[1]));
                $query->whereDate("created_at", ">=", $startDate)
                    ->whereDate("created_at", "<=", $endDate);
            }
        };

        $totalLoginActivity = Log::where($commonQuery)->where("action", "LOGIN")->count();
        $totalUser = User::where($commonQuery)->count();
        $totalUnit = Unit::where($commonQuery)->count();
        $totalJabatan = Jabatan::where($commonQuery)->count();

        $data = [
            "total_login" => $totalLoginActivity,
            "total_pegawai" => $totalUser,
            "total_unit" => $totalUnit,
            "total_jabatan" => $totalJabatan,
        ];

        return response()->json([
            'statusCode' => 200,
            'status' => true,
            'message' => 'Displaying data...',
            'data' => $data
        ]);
    }

    public function topLoginActivity(Request $request)
    {

        $data = $this->getActivity($request, 'LOGIN');

        return response()->json([
            'statusCode'    => 200,
            'status'        => true,
            'message'       => 'Displaying data...',
            'data'          =>  $data
        ]);
    }

    public function userActivity(Request $request)
    {

        $data = $this->getActivity($request, 'DATA');

        return response()->json([
            'statusCode'    => 200,
            'status'        => true,
            'message'       => 'Displaying data...',
            'data'          =>  $data
        ]);
    }

    public function getActivity(Request $request, $action_type)
    {
        $query = Log::with('user')->where(function ($query) use ($request) {
            if ($request->q != '') {
                $query->whereHas('user', function ($q) use ($request) {
                    $q->where('name', 'LIKE', '%' . $request->q . '%');
                });
            }

            if ($request->rentang_tanggal && count($request->rentang_tanggal) == 2) {
                $startDate = date('Y-m-d', strtotime($request->rentang_tanggal[0]));
                $endDate = date('Y-m-d', strtotime($request->rentang_tanggal[1]));
                $query->whereDate("created_at", ">=", $startDate)
                    ->whereDate("created_at", "<=", $endDate);
            }
        });

        if ($action_type === 'LOGIN') {
            $data = $query
                ->selectRaw('user_id, COUNT(*) as login_count')
                ->where('action', 'LOGIN')
                ->groupBy('user_id')
                ->havingRaw('COUNT(*) > 25') 
                ->orderBy('login_count', $request->sort_order)
                ->limit(10)
                ->get();
        } else {
            $data = $query->whereNot("action", "LOGIN")
                ->orderBy('created_at', $request->sort_order)
                ->paginate($request->per_page);
        }

        return $data;
    }
}
