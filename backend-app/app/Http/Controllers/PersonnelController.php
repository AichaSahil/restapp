<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PersonnelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Personnel::select('numPersonnel','nomPersonnel',	'prenomPersonnel',	'age')->get(); //we can use select or all but it's better to use select to determineted just a data from this class
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomPersonnel' => 'required',
            'prenomPersonnel' =>  'required',	
            'age' =>  'required'
        ]);
        Personnel::create($request->post());
        return response()->json([
            'message' => 'personnel added sucessfully'
        ]);
    }

 
    public function show(Personnel $personnel)
    {
        return response() -> json([
            'message' => $personnel
        ]);
    }

   
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Personnel  $personnel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Personnel $personnel)
    {
        $request->validate([
            'nomPersonnel' => 'required',
            'prenomPersonnel' =>  'required',	
            'age' =>  'required'
        ]);

        $personnel->fill($request->post())->update(); //update data
        $personnel->save();
        return response()->json([
            'message' => 'personnel update sucessfully'
        ]);
    }

    
    public function destroy(Personnel $personnel)
    {
        $personnel->delete();
        return response()->json([
            'message' => 'personnel deleted sucessfully'
        ]);
        
    }
}
