<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\URL;
use App\Helpers\Helper;
use Auth;

class URLController extends Controller
{
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

        $short_URL = Helper::get_short_URL($is_URL_verbal);

        $url = new URL();

        $url->full_URL = $inputs["url"];

        $url->short_URL = $short_URL;

        $url->user_id = Auth::id();

        $url->save();

        return response()->json(["errors" => [], "success" => true], 201);

    }
}