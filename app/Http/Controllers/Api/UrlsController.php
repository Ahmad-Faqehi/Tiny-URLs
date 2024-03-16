<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Urls;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UrlsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
//    public function index()
//    {
//        //
//
//        return "hello from urls api";
//    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $user_id=null;
        $validator = Validator::make($request->all(), [
            'url'=>'required|url'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        #To check if user has access token, and if is, get his user id.
        if($request->header('Authorization') && auth('sanctum')->user())
            $user_id = auth('sanctum')->user()->id;




        $randomUri = Str::random(6);
        #Todo: check if $randomUri isn't already exist on db


        $url = Urls::create([
            'original_url' => $request->url,
            'uri_token' => $randomUri,
            'user_id' => $user_id
        ]);

        if ($url):
            return response()->json([
                'status' => 'successfully',
                'uri_token' => $randomUri
            ],200);
        endif;

        return  response()->json([
            'status' => 'error',
            'message' => 'Error creating the shortcut.'
        ],400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uri)
    {
        //
        if(!empty($uri))
            $link = Urls::where('uri_token', '=' ,$uri)->firstOrFail();
            if ($link)
                return Redirect::to($link->original_url);

    }

    /**
     * Update the specified resource in storage.
     */
//    public function update(Request $request, string $id)
//    {
//        //
//    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
