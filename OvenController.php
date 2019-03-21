<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Table_oven;

class OvenController extends Controller
{
    //
    protected function begin(){
    	$array=array();
    	$kol=0;
    	for ($i=1;$i<=3;$i++){ 	
    		$array[$i]=mt_rand(1,3);
    		$kol=$kol+$array[$i]; 
    	}
    	$array[4]=10-$kol;
    	return $array;
    }

    protected function id_max($array){
    	$max=0;
    	$max_id=1;
    	for ($i=1;$i<=4;$i++){
    		if ($max<$array[$i]){
    			$max=$array[$i];
    			$max_id=$i;
    		}
    	}
    	return $max_id;
    }

    protected function check($array){

    	for ($i=1;$i<=4;$i++){
    		if ($array[$i]<2){
    			$array[$this->id_max($array)]--;
    			$array[$i]++;
    		}
    	}

    	return $array;

    }

    public function day($array,$id_day){

    	$rand=mt_rand(1,4);

    	$array[$rand]++;

    	if (($id_day % 10) ==0){
    		$rand=mt_rand(1,4);
    		$array[$rand]--;

    	}

    	return $array;

    }
    public function show(){

    	return view('oven');
    }
    public function oven_day(Request $request){

    	$array=$request->input('array',"[1,1,1,2]");
    	$day=$request->input('days',67);

    	$model=new Table_oven;
    	$model->day=$day;
    	$model->zagon1=$array[0]; 
    	$model->zagon2=$array[1]; 
    	$model->zagon3=$array[2]; 
    	$model->zagon4=$array[3];
    	$model->all_plus=$day;
    	$model->all_minus=floor($day/10);
    	$model->save();

    	
    	return response()->json(['success'=>$request->all()]);


    }

    public function oven_history(Request $request){    	

    	$first_model=Table_oven::where('day',1)->orderBy('id', 'desc')->first();
    	$models=Table_oven::where('id','>=',$first_model->id)->orderBy('id')->get();
    	
    	return response()->json($models);
    }


}
