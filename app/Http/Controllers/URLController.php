<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\URL;
use App\Helpers\Helper;
use Auth;

class URLController extends Controller
{

    function deleteURL(Request $request){

        if(!Auth::id()) return response()->json(["errors" => ["Please log in."], "success" => false], 401);

        $inputs = $request->all();

        $validator = Validator::make($inputs, [
            "id" => "required"
        ],
        [
            "id.required" => "URL id is not provided.",
        ]);

        if(!$validator->passes()){
            return response()->json(["errors" => $validator->errors()->all(), "success" => false], 400);
        }

        $id = $inputs["id"];

        $url = URL::where("id", "=", $id)->first();

        if(!$url){
            return response()->json(["errors" => ["Given id does not match any URL."], "success" => false], 400);
        }

        if(!$url->user_id || Auth::id() != $url->user_id){
            return response()->json(["errors" => ["This URL does not belong to you."], "success" => false], 403);
        }

        $url->delete();

        return response()->json(["errors" => [], "success" => true], 200);

    }

    function getUserLinksPage(Request $request){

        if(!Auth::id()) return redirect("/login");

        $urls = URL::where("user_id", "=", Auth::id())->simplePaginate(10);

        return view("my-links")->with("urls", $urls);

    }

    function createURL(Request $request){

        $inputs = $request->all();

        $validator = Validator::make($inputs, [
            "url" => "required|max:250|url"
        ],
        [
            "url.required" => "Please enter a link.",
            "url.max" => "Link must be less than 250 characters long.",
            "url.url" => "Given link is not a valid URL."
        ]);

        if(!$validator->passes()){
            return response()->json(["errors" => $validator->errors()->all(), "success" => false], 400);
        }

        $is_URL_verbal = isset($inputs["url_type"]) && $inputs["url_type"] == "verbal" ? true : false;

        $short_URL = "";

        while(true){

            $short_URL = Helper::get_short_URL($is_URL_verbal);

            if(!URL::where("short_URL", "=", $short_URL)->exists()) break;

        }

        $url = new URL();

        $url->full_URL = $inputs["url"];

        $url->short_URL = $short_URL;

        $url->user_id = Auth::id();

        $url->save();

        return response()->json(["errors" => [], "success" => true, "shortURL" => $short_URL], 201);

    }

    function getSingleURL(Request $request, $short_URL){

        $url = URL::where("short_URL", "=", $short_URL)->first();

        if(!$url){
            return view('404');
        }

        return view('single-url')->with("url", $url);

    }

    function redirectToURL(Request $request, $short_URL){

        $url = URL::where("short_URL", "=", $short_URL)->first();

        if(!$url){
            return view('404');
        }

        return redirect($url->full_URL);

    }

}