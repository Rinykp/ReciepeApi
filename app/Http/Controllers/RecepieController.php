<?php

namespace App\Http\Controllers;

use App\Models\Recepie;
use App\Models\Rate;
use Illuminate\Http\Request;
use Validator;

class RecepieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $recepie =Recepie::all();
        return response()->json($recepie);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if($validator->fails()){
            $response = array('response'=> $validator->messages(),'success'=>false);
            return $response;
        }
        else{
            $vegetarian = $request->vegetarian;
            if ($vegetarian == 'veg') {
                $veg=0;
            }elseif($vegetarian == 'non veg'){
                $veg=1;
            }else{
                $veg=0; 
            }
            $recepie= new Recepie;
            $recepie->name = $request->name;
            $recepie->prep_time = $request->prep_time;
            $recepie->difficulty = $request->difficulty;
            $recepie->vegetarian = $veg;
            $recepie->save();
            return response()->json($recepie);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $recepie =Recepie::find($id);
        return response()->json($recepie);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if($validator->fails()){
            $response = array('response'=> $validator->messages(),'success'=>false);
            return $response;
        }
        else{
            $vegetarian = $request->vegetarian;
            if ($vegetarian == 'veg') {
                $veg=0;
            }elseif($vegetarian == 'non veg'){
                $veg=1;
            }else{
                $veg=0; 
            }

            $recepie= Recepie::find($id);
            $recepie->name = $request->name;
            $recepie->prep_time = $request->prep_time;
            $recepie->difficulty = $request->difficulty;
            $recepie->vegetarian = $request->has('veg');
            $recepie->save();
            return response()->json($recepie);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $recepie= Recepie::find($id);
        $recepie->delete();
        
        $response = array('response'=> 'Recepie deleted','success'=>true);
        return $response;
    }

    public function rate_store(Request $request ,$id)
    {
        $validator = Validator::make($request->all(), [
            'rate' => 'required',
        ]);
        if($validator->fails()){
            $response = array('response'=> $validator->messages(),'success'=>false);
            return $response;
        }
        else{

            $recepie_id = Rate::where('recepie_id', '=', $id)->first();
            if ($recepie_id === null) {
                  // recepie_id does not exist

                $rate= new Rate;
                $rate->recepie_id = $id;
                $rate->rate = $request->rate;
                $rate->flag = "0";
                $rate->save();
                return response()->json($rate);
                }
            else{
                $response = array('response'=> 'Rating found','success'=>true);
                return $response;
                       
                }
        }
    }
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search' => 'required',
        ]);
        if($validator->fails()){
            $response = array('response'=> $validator->messages(),'success'=>false);
            return $response;
        }
        else{
            
            $search = Recepie::where('name','LIKE','%'.$request->search.'%')->get();
                return response()->json($search);
                }
                
         
    }

}
