<?php

namespace App\Http\Controllers;

use App\Models\Dessert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DessertController extends Controller
{
    
    public function index()
    {
        return Dessert::select('idDessert','titleDessert'	,'prixDessert'	,'imgDessert')->get();
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'titleDessert' => 'required',
            'prixDessert' => 'required',
            'imgDessert' => 'required|image'
        ]);

        $imageDessert =Str::random().','.$request->imgDessert->getClientOriginalExtension();
        Storage::disk('public')->putFileAs('dessert/imgDessert',$request->imgDessert,$imageDessert);
        Dessert::create($request->post()+ ['imgDessert' => $request->imgDessert]);
        return response()->json([
            'message'=>'Dessert added successful'
        ]);
    }

    
    public function show(Dessert $dessert)
    {
        return response()->json([
            'message'=>$dessert
        ]);
    }

  
    public function update(Request $request, Dessert $dessert)
    {
        $request->validate([
            'titleDessert' => 'required',
            'prixDessert' => 'required',
            'imgDessert' => 'required|image'
        ]);
        $dessert->fill($request->post())->update();

        if($request->hasFile('imgDessert')){
        if($dessert->imgDessert){
            $exist = Storage::disk('public')->exists("dessert/imgDessert{$dessert->imgDessert}"); //if image  exist ,show me it 
            if($exist){
                Storage::disk('public')->delete("dessert/imgDessert{$dessert->imgDessert}"); //if image  exist ,show me it and delete it to put a new img
            }
        }


        $imageDessert =Str::random().','.$request->imgDessert->getClientOriginalExtension();
        Storage::disk('public')->putFileAs('dessert/imgDessert',$request->imgDessert,$imageDessert);
        $dessert->imgDessert = $imageDessert;
        $dessert->save();
        
        }
        return response()->json([
            'message'=>'Dessert added successful'
        ]);
    }


    public function destroy(Dessert $dessert)
    {
        if($dessert->imgDessert){
            $exist = Storage::disk('public')->exists("dessert/imgDessert{$dessert->imgDessert}"); //if image  exist ,show me it 
            if($exist){
                Storage::disk('public')->delete("dessert/imgDessert{$dessert->imgDessert}"); //if image  exist ,show me it and delete it to put a new img
            }
        }
        return response()->json([
            'message'=>'Dessert deleted successful'
        ]);
    }
}
