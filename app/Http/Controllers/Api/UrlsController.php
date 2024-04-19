<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Urls;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Benchmark;
use App\Models\Config;


class UrlsController extends Controller
{
    public bool $useRedis = true;
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


        $randomUri = Str::random(3);
        #Todo: check if $randomUri isn't already exist on db

        while (  Urls::where('uri_token', '=' ,$randomUri)->get()->count() == 1 ){

            $randomUri = Str::random(3);
        }

        $url = Urls::create([
            'original_url' => $request->url,
            'uri_token' => $randomUri,
            'user_id' => $user_id
        ]);

        if ($url):
            if ($this->useRedis)
                Redis::set('url_'.$randomUri,$request->url);
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


        $isRedis = $this->useRedis;
        if(!empty($uri))
            #TO search uri in redis
            if ($isRedis)
                $link =  Redis::get('url_' . $uri);

                if (isset($link)){
                    return Redirect::to($link);

                }else{
                    $link = Urls::where('uri_token', '=' ,$uri)->firstOrFail();
                    if($isRedis)
                        Redis::set('url_'.$link->uri_token,$link->original_url);
                    return Redirect::to($link->original_url);
                }


        return  false;
    }

    public function isRedisReady($connection = null)
    {
        $isReady = true;
        try {
            $redis = Redis::connection($connection);
            $redis->connect();
            $redis->disconnect();
        } catch (\Exception $e) {
            $isReady = false;
        }

        return $isReady;
    }

    public function isRedisReady_db()
    {
        $isReady = true;
        if (boolval(Config::where('name', '=', 'redis')->firstOrFail()->status)){
            $isReady = true;
        }else{
            $isReady = false;
        }

        return $isReady;
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

    public function test()
    {
        //
        return "Hello World";
    }
}
