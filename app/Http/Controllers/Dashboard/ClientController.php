<?php

namespace App\Http\Controllers\Dashboard;



use App\Models\Client;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function clients(){

        return view('dashboard.clients.index');
    }


    public function preview_clients($id){

        $preview_client = Client::find($id);

        if($preview_client){

            return view('dashboard.clients.preview', compact('preview_client'));
        }else{

            return redirect()->back();
        }

    }




    public function get_all_clients(Request $request)
    {
        if ($request->ajax()) {
            $data = Client::orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                // ->editColumn('name', function ($data) {
                //     return '<span style="color:black">'.$data->name.'</span>';
                // })

                ->addColumn('action', function ($data) {
                    return view('dashboard.clients.btn.action', compact('data'));
                })

                ->rawColumns([''])

                ->make(true);
        }
    }




}
