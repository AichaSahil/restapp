<?php

namespace App\Http\Controllers;

use App\Models\Plat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PlatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Plat::select('idPlat','titlePlat','prixPlat','imgPlat')->get(); //we can use select or all but it's better to use select to determineted just a data from this class
        
    }

  
    public function store(Request $request)
    {
        $request->validate([
            'titlePlat' => 'required',
            'prixPlat' => 'required',
            'imgPlat' => 'required|image'
        ]);

        $imagePlat =Str::random().','.$request->imgPlat->getClientOriginalExtension();
        Storage::disk('public')->putFileAs('plat/imgPlat',$request->imgPlat,$imagePlat);
        Plat::create($request->post()+ ['imgPlat' => $request->imgPlat]);
        return response()->json([
            'message'=>'Plat added successful'
        ]);
    }

    
    public function show(Plat $plat)
    {
         return response()->json([
            'message'=>$plat
        ]);
    }

  
    public function update(Request $request, Plat $plat)
    {
        $request->validate([
            'titlePlat' => 'required',
            'prixPlat' => 'required',
            'imgPlat' => 'nullable' //you can store null values to that column 
        ]);

        $plat->fill($request->post())->update(); //here we update a data

       if($request->hasFile('imgPlat')){
        if($plat->imgPlat){
            $exist = Storage::disk('public')->exists("plat/imgPlat{$plat->imgPlat}"); //if image  exist ,show me it 
            if($exist){
                Storage::disk('public')->delete("plat/imgPlat{$plat->imgPlat}"); //if image  exist ,show me it and delete it to put a new img
            }
        }

        $imagePlat =Str::random().','.$request->imgPlat->getClientOriginalExtension();
        Storage::disk('public')->putFileAs('plat/imgPlat',$request->imgPlat,$imagePlat);
        $plat->imgPlat = $imagePlat;
        $plat->save();
       }

        return response()->json([
            'message'=>'Plat updated successful'
        ]);
    }


    public function destroy(Plat $plat)
    {
        if($plat->imgPlat){
            $exist = Storage::disk('public')->exists("plat/imgPlat{$request->imgPlat}"); //if image  exist ,show me it 
            if($exist){
                Storage::disk('public')->delete("plat/imgPlat{$request->imgPlat}"); //if image  exist ,show me it and delete it to put a new img
            }
        }
        $plat->delete();
        return response()->json([
            'message'=>'Plat deleted successful'
        ]);
    }
}
