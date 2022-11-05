<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $photos = Photo::latest("id")->paginate(10);
        return response()->json($photos);
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
            "product_id"=>"required|exists:products,id",
            "photos"=>"required",
            "photos.*"=>"mimes:jpeg,png|max:512"
        ]);

        foreach ($request->file('photos') as $key=>$photo){
            $newName = $photo->store("public");

            Photo::create([
                "product_id"=>$request->product_id,
                "name"=>$newName
            ]);
        }

        return response()->json(["message"=>"Photos uploaded successfully!"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $photo = Photo::find($id);
        if(is_null($photo)){
            return response()->json(["message"=>"Photo not found!"], 404);
        }
        return response()->json($photo);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $photo = Photo::find($id);
        if(is_null($photo)){
            return response()->json(["message"=>"Photo not found!"], 404);
        }
        $photo->delete();

        return response()->json([], 204);
    }
}
