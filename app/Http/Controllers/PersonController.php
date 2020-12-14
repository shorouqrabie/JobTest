<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use App\Person;
use Image;
use File;
use Hash;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get the average of ages
        $avg = Person::all()->avg('age');
        // map over all person records, modfiy it with adding boolean value true if the age is above $avg
        $users = Person::all()->map(function ($item, $key) use ($avg) {
                    $item->aboveAvg = ($item->age > $avg);
                    return $item;
                })->sortByDesc('created_at');
        return view('users')->with(['users' => $users]);
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
    public function store(StorePersonRequest $request)
    {
        $imageName = $this->uploadImage($request->imgfile);
        $person = Person::create($request->except('_token', 'password') + ['personal_photo' => $imageName, 'password' =>  Hash::make($request->password)]);  
        return response()->json(['person' => $person]);
    }


    public function uploadImage($file)
    {
        $path = public_path('personal_photos/');
        $image = Image::make($file);
        $imageName = time().'-'.$file->getClientOriginalName();
        $image->resize(256,256);
        $image->save($path.$imageName);    
        return $imageName;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(UpdatePersonRequest $request, $id)
    {
        $updated = Person::find($id)->update($request->except('_token'));
        if($updated) response()->json('success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
