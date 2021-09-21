<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Thread, Post, Report};
use Illuminate\Validation\Rule;

class ReportController extends Controller
{
    public function thread_report(Request $request, Thread $thread) {
        $this->authorize('thread_report', [Report::class, $thread->id]);
        $data = $request->validate([
            'body'=>'required_if:report_type,moderator-intervention|max:500|min:10',
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

    public function post_report(Request $request, Post $post) {
        $this->authorize('post_report', [Report::class, $post->id]);
        $data = $request->validate([
            'body'=>'required_if:report_type,moderator-intervention|max:500|min:10',
            'report_type'=>Rule::in([
                'spam', 'rude-or-abusive', 'not-a-reply', 'moderator-intervention'
            ])
        ]);

        $report = new Report;
        $report->user_id = auth()->user()->id;
        if($request->has('body')) {
            $report->body = $data['body'];
        }
        $report->report_type = $data['report_type'];

        $post->reports()->save($report);
    }
}
