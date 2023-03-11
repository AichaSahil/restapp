<?php

namespace App\Http\Controllers;

use App\Models\Boisson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BoissonController extends Controller
{
    
    public function index()
    {
        return Boisson::select('idBoisson','titleBoisson'	,'prixBoisson'	,'imgBoisson')->get(); //we can use select or all but it's better to use select to determineted just a data from this class
        
    }

  
    public function store(Request $request)
    {
        $request->validate([
            'titleBoisson' => 'required',
            'prixBoisson' => 'required',
            'imgBoisson' => 'required|image'
        ]);

        $imageBoisson =Str::random().','.$request->imgBoisson->getClientOriginalExtension();
        Storage::disk('public')->putFileAs('boisson/imgBoisson',$request->imgBoisson,$imageBoisson);
        Boisson::create($request->post()+ ['imgBoisson' => $request->imgBoisson]);
        return response()->json([
            'message'=>'Boisson added successful'
        ]);
    }

  
    public function show(Boisson $boisson)
    {
        return response()->json([
            'message'=>$boisson
        ]);
    }

 
    public function update(Request $request, Boisson $boisson)
    {
        $request->validate([
            'titleBoisson' => 'required',
            'prixBoisson' => 'required',
            'imgBoisson' => 'required|image'
        ]);

        $boisson->fill($request->post())->update();

        if($request->hasFile('imgBoisson')){
            if($boisson->imgBoisson){
                $exist = Storage::disk('public')->exists("boisson/imgBoisson{$boisson->imgBoisson}"); //if image  exist ,show me it 
                if($exist){
                    Storage::disk('public')->delete("boisson/imgBoisson{$boisson->imgBoisson}"); //if image  exist ,show me it and delete it to put a new img
                }
            }
            $imageBoisson =Str::random().','.$request->imgBoisson->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('boisson/imgBoisson',$request->imgBoisson,$imageBoisson);
            $boisson->imgBoisson = $imageBoisson;
            $boisson->save();

        }

        return response()->json([
            'message'=>'Boisson added successful'
        ]);
    }

   
    public function destroy(Boisson $boisson)
    {
        if($boisson->imgBoisson){
            $exist = Storage::disk('public')->exists("boisson/imgBoisson{$request->imgBoisson}"); //if image  exist ,show me it 
            if($exist){
                Storage::disk('public')->delete("boisson/imgBoisson{$request->imgBoisson}"); //if image  exist ,show me it and delete it to put a new img
            }
        }
        $boisson->delete();
        return response()->json([
            'message'=>'boisson deleted successful'
        ]);
    }
}
