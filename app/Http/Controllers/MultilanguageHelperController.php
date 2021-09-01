<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;

class MultilanguageHelperController extends Controller
{
    public function index() {
        if(auth()->user() /** && has_role('admin') */)
            return view('multilanguage.index');
    }

    public function get_keys(Request $request) {
        if(!auth()->user() /** || !has_role('admin') */) {
            return '';
        }
        if(!in_array($request->lang, ['fr', 'ma-ar'])) {
            return '';
        }

        $lang = $request->lang;
        // Building language json file path.
        $lang_file_path = resource_path("lang/$lang.json");
        
        // Fetch file content
        $content = File::get($lang_file_path);
        
        return $content;
    }
}
