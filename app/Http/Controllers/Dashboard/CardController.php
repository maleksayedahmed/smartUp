<?php

namespace App\Http\Controllers\Dashboard;



use App\Models\Card;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class CardController extends Controller
{
    public function cards(){

        return view('dashboard.cards.index');
    }

    public function get_all_cards(Request $request)
    {
        if ($request->ajax()) {
            $data = Card::orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                // ->editColumn('name', function ($data) {
                //     return '<span style="color:black">'.$data->name.'</span>';
                // })


                ->addColumn('action', function ($data) {
                    return view('dashboard.cards.btn.action', compact('data'));
                })

                ->rawColumns(['icon'])

                ->make(true);
        }
    }



    public function update(Request $request, $id)
    {
    try {


         $validator = Validator::make($request->all(),
                [
                     'title_ar' => 'required',
                     'title_en' => 'required',
                    'description_ar' => 'required',
                    'description_en' => 'required'
                ],
                [
                     'title_ar.required' => 'حقل العنوان العربي مطلوب',
                    'title_en.required' => 'حقل العنوان الإنجليزي مطلوب',
                      'description_ar.required' => 'حقل الوصف العربي مطلوب',
                 'description_en.required' => 'حقل الوصف الإنجليزي مطلوب',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->messages()
                ], 422);
            }

        $card = Card::findOrFail($id);
        $card->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث البطاقة بنجاح'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'حدث خطأ: ' . $e->getMessage()
        ], 500);
    }
}


public function preview_cards($id){

$preview_card = Card::find($id);

if($preview_card){

    return view('dashboard.cards.preview', compact('preview_card'));
}else{

    return redirect()->back();
}

}

}

