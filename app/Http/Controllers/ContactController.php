<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function contactus(Request $request) {
        $rate_limit_reached = false;
        $requests_peak = 2; // Only 2 messages per day per user (guest or auth)
        if(Auth::check()) {
            if(ContactMessage::where('user', auth()->user()->id)->count() >= $requests_peak) {
                $rate_limit_reached = true;
            }
        } else {
            if(ContactMessage::where('ip', $request->ip())->count() >= $requests_peak) {
                $rate_limit_reached = true;
            }
        }
        return view('contactus')->with(compact('rate_limit_reached'));
    }

    public function store_contact_message(Request $request) {
        $data;
        if(Auth::check()) {
            $data = $request->validate([
                'message'=>'required|max:2000'
            ]);
            $data['user'] = auth()->user()->id;
        } else {
            $data = $request->validate([
                'firstname'=>'required|max:100',
                'lastname'=>'required|max:100',
                'email'=>'required|email:rfc,dns|max:400',
                'company'=>'sometimes|max:200',
                'phone'=>'sometimes|max:200',
                'message'=>'required|max:2000'
            ]);
        }

        /**
         * Notica that we cannot use a policy here because guest users also could send messages
         * IMPORTANT: the authorization must be after validation because user could make 10 requests but all of them are not submitted because of a validation error
         */
        /**
         * If the user is authenticated we see if there are 2 records today with the same user; if so we prevent sending
         * If the user is a guest we check the same condition with ip address
         */
        $requests_peak = 2;
        if(Auth::check()) {
            if(ContactMessage::where('user', auth()->user()->id)->count() >= $requests_peak) {
                return $this->deny(__('You have a limited number of 2 messages per day'));
            }
        } else {
            if(ContactMessage::where('ip', $request->ip())->count() >= $requests_peak) {
                return $this->deny(__('You have a limited number of 2 messages per day'));
            }
        }

        $data['ip'] = $request->ip();
        \Session::flash('message', __('Your message has been sent successfully !'));
        ContactMessage::create($data);
    }
}
