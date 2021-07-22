<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Thread, Report};
use Illuminate\Validation\Rule;

class ReportController extends Controller
{
    public function thread_report(Request $request, Thread $thread) {
        $data = $request->validate([
            'body'=>'sometimes|max:500|min:10',
            'report_type'=>Rule::in([
                'spam', 'rude-or-abusive', 'low-quality', 'moderator-intervention'
            ])
        ]);

        $report = new Report;
        $report->user_id = auth()->user()->id;
        if($request->has('body')) {
            $report->body = $data['body'];
        }
        $report->report_type = $data['report_type'];

        $thread->reports()->save($report);
    }
}
