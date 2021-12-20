<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\MyEvent;
use App\Http\Resources\MyEventResource;
class MyEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEvent()
    {
        return MyEvent::with(["category", "user", "join"])->latest()->get();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */ 
    public function createEvent(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:1999|',
            'title' => 'required',
            'description' => 'required',
            'country' => 'required',
            'city' => 'required',
            'start_date' => 'required|before:end_date',
            'end_date' => 'required|after:start_date',
            
        ]);

           

        $myevent = new MyEvent();
        $myevent->user_id = $request->user_id;
        $myevent->category_id = $request->category_id;
        $myevent->image = $request->image;
        if($request->image !== null) {
            $request->file('image')->store('public/images/events');
            $myevent->image = $request->file('image')->hashName();
        } else {
            $myevent->image = "";
        }
        $myevent->title = $request->title;
        $myevent->description = $request->description;
        $myevent->country = $request->country;
        $myevent->city = $request->city;
        $myevent->start_date = $request->start_date;
        $myevent->end_date = $request->end_date;
        
        $myevent->save();
        return response()->json(["message" => "Created", 'data'=>$myevent],201);
    } 
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOneEvent($id)
    {
        return MyEvent::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateEvent(Request $request, $id)
    {
       
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'country' => 'required',
            'city' => 'required',
            'start_date' => 'required|before:end_date',
            'end_date' => 'required|after:start_date',
            
        ]);

        $myevent = MyEvent::findOrFail($id);
        $myevent->user_id = $request->user_id;
        $myevent->category_id = $request->category_id;
        $myevent->title = $request->title;
        $myevent->description = $request->description;
        $myevent->country = $request->country;
        $myevent->city = $request->city;
        $myevent->start_date = $request->start_date;
        $myevent->end_date = $request->end_date;
        
        $myevent->save();
        return response()->json(["message" => "Updated", 'data'=>$myevent],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyEvent($id)
    {
        $isDeleted = MyEvent::destroy($id);
        if($isDeleted === 1){
            return response()->json(["message" => "Deleted"],200);
        }else{
            return response()->json(["message" => "ID not found"],401);
        } 
    }

    public function search($title)
    {
        return MyEvent::where('title','like', '%'. $title . '%')->with(["category", "user", "join"])->get();
    }

    public function searchCity($city)
    {
        return MyEvent::where('city','like', '%'. $city . '%')->with(["category", "user", "join"])->get();
    }
}
