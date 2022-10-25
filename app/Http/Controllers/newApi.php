<?php

namespace App\Http\Controllers;

use App\Models\Newdata;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator as ValidationValidator;
use Illuminate\Support\Facades\Validator;

class newApi extends Controller
{
    public function userData($id =null){
        $data= $id?Newdata::find($id):Newdata::all();
        return $data;
    }
    public function userDetails($id){
        $data=Newdata::find($id);
        return $data;
    }
    public function addUser(Request $request){
        $data=new Newdata;
        $data->name=$request->name;
        $data->emp_id=$request->emp_id;
        
        $data->save();
        return ["result"=>"data has been saved"];
    }

    public function updateUser(Request $request){
        $data= Newdata::find($request->id);
        $data->name=$request->name;
        $data->emp_id=$request->emp_id;
        $result=$data->save();
       if($result){
        return ["result"=>"data has  updated successfully"];
       }
       else{
        return ["result"=>"data has not updated"];
       }
    }
    public function deleteUser(Request $request){
        $data= Newdata::find($request->id);
        $result=$data->delete();
       if($result){
        return ["result"=>"data has  deleted successfully"];
       }
       else{
        return ["result"=>"data has not deleted"];
       }
    }

    public function search($name){
    $searchData= Newdata::where('name',"like","%".$name."%")->get();
 
    if($searchData!="[]"){
        return  $searchData;
    }
    else{
        return ["result"=>"No data found"];
    }
    }

    // use validator for api calls

    public function addMembers(Request $request){

        $rules=array(
            "name"=>"required",
            "emp_id"=>"required",
        );
        $validator= Validator::make($request->all(),$rules);
        if ($validator->fails()) {
           return response()->json($validator->errors(),401);
        }
        else {
            $data=new Newdata;
            $data->name=$request->name;
            $data->emp_id=$request->emp_id;
            $result=$data->save();
            if ($result) {
                return ["result"=>"data has been saved"];
            }
            else{
                return ["result"=>"operation failed"];
            }
            
        }

    }

    public function fileUpload(Request $request){
        $result=$request->file('file')->store('apiimage');
        return ["result"=>"file uploaded"];
    }





}
