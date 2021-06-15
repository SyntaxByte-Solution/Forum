<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function store(Request $request) {
        $data = [];
        if(!auth()->user()) {
            $d = $request->validate([
                'email'=>'required|email:rfc,dns|max:300',
            ]);
            $data['email'] = $d['email'];
            $data['user_id'] = null;

        } else {
            $data['email'] = auth()->user()->email;
            $data['user_id'] = auth()->user()->id;
        }

        $d = $request->validate([
            'feedback'=>'required|min:2|max:2600',
        ]);
        $data['feedback'] = $d['feedback'];

        Feedback::create($data);
    }
}
