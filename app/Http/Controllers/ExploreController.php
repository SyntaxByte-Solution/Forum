<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Forum, Thread};
use App\View\Components\IndexResource;
use Carbon\Carbon;

class ExploreController extends Controller
{
    const PAGESIZE = 8;
    const FETCH_PAGESIZE = 5;
    const INITIAL_FETCH_HOURS = 24;

    public function explore() {
        $forums = Forum::all()->take(6);
        $threads = collect([]);
        $skip = 0;
        $sort_icon;
        $sort_title;
        
        // This code inside every switch case executed only in the first time the user visit explore page
        $sortby = request()->has('sortby') ? request()->get('sortby') : 'popular-and-recent';
        switch($sortby) {
            case 'popular-and-recent':
                /**
                 * First we take all threads created in the last 24 hours and sort them by views & creation date and return 
                 * 8 (pagesize) of them to the user; of course the returned threads are sorted with the selected sort key (the curret is popular and recent)
                 * When threads returned are not enough (less than pagesize) we increase the number of hours to increase the range
                 * of time to cover more threads
                 */
                $hours_from = self::INITIAL_FETCH_HOURS;
                while($threads->count() < self::PAGESIZE) {
                    $threads = Thread::where('created_at', '>=', 
                        Carbon::now()->subHours($hours_from)->toDateTimeString())
                        ->orderBy('view_count', 'desc')
                        ->orderBy('created_at', 'desc')->get();
                    $hours_from++;
                }

                if($threads->count() > self::PAGESIZE) {
                    $skip = self::PAGESIZE;
                }

                $sort_title = __('Popular and recent');
                $sort_icon = "M380.27,162.56l-16-13-7.47,19.26c-.14.37-14.48,36.62-36.5,30A15.58,15.58,0,0,1,310,190c-5.47-11.72-3.14-32.92,5.93-54,12.53-29.18,7-59.75-15.88-88.41a161.1,161.1,0,0,0-36.32-32.88L240.23,0l.52,27.67c0,.49.52,49.65-35.88,67.67-22.3,11-38.26,29.31-45,51.43a79,79,0,0,0,7.21,62.09c4.44,7.67,5.78,14.19,4,19.35-2.55,7.38-10.79,11.18-13.25,12.17-26,10.45-43-24.44-43.74-25.88l-11.87-25.33-14.54,23.9A196.29,196.29,0,0,0,59.18,315.19c0,107.73,87,195.51,194.46,196.78.78,0,1.57,0,2.36,0h0c108.53,0,196.82-88.29,196.82-196.81a196.15,196.15,0,0,0-72.55-152.63ZM194.44,420.43v-.19c-.15-11.94,2.13-24.75,6.78-38.22l37,10.82.37-19.63c.57-30.07,17.53-48.52,31.08-58.51a135.37,135.37,0,0,0,16.38,40.84c8.53,13.92,16.61,25.72,24.06,36.39,4.79,6.87,7.51,17.24,7.45,28.44v.08A61.52,61.52,0,0,1,256,482h0a61.63,61.63,0,0,1-61.55-61.55ZM338.62,460a91.08,91.08,0,0,0,9-39.56c.08-17.5-4.48-33.73-12.85-45.73s-15.42-22.39-23.08-34.89c-8.54-14-13.68-30.42-15.7-50.3l-2-19.44L275.7,277c-1.72.65-17.19,6.75-33.06,21.14-16.82,15.26-27.68,34.14-32,55.33l-26.84-7.85-5.29,12.08c-9.59,21.87-14.34,43-14.11,62.78a91,91,0,0,0,9.05,39.57,166.81,166.81,0,0,1-71-210.09c1.33,1.47,2.75,2.94,4.25,4.39,18.39,17.7,40.54,22.62,62.38,13.85,14.76-5.92,25.85-16.94,30.44-30.23,3.27-9.46,4.81-24.8-6.38-44.17a48.12,48.12,0,0,1-4.46-38.38c4.26-14.1,14.75-25.89,29.53-33.22C249.31,106.83,262,77.9,267.22,56A117.11,117.11,0,0,1,277,66.83c15.42,19.56,19.23,38.82,11.3,57.26-12.67,29.49-14.74,58.86-5.55,78.57a45.48,45.48,0,0,0,28.87,24.93c20.6,6.18,40.75-1,56.73-20.25a98.36,98.36,0,0,0,6.64-9A166.76,166.76,0,0,1,338.62,460Z";
                break;
            case 'replies-and-likes':
                $hours_from = self::INITIAL_FETCH_HOURS;
                while($threads->count() < self::PAGESIZE) {
                    $threads = Thread::where('created_at', '>=', 
                        Carbon::now()->subHours($hours_from)->toDateTimeString())
                        ->orderBy('created_at', 'desc')
                        ->get()
                        ->sortBy(function($thread) {
                            return -$thread->postsandlikescount;
                        });
                    $hours_from++;
                }

                if($threads->count() > self::PAGESIZE) {
                    $skip = self::PAGESIZE;
                }

                $sort_title = __('Replies and likes');
                $sort_icon = "M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z";
                break;
            case 'votes':
                $hours_from = self::INITIAL_FETCH_HOURS;
                while($threads->count() < self::PAGESIZE) {
                    $threads = Thread::where('created_at', '>=', 
                        Carbon::now()->subHours($hours_from)->toDateTimeString())
                        ->orderBy('created_at', 'desc')
                        ->get()
                        ->sortBy(function($thread) {
                            return -$thread->votevalue;
                        });
                    $hours_from++;
                }

                if($threads->count() > self::PAGESIZE) {
                    $skip = self::PAGESIZE;
                }

                $sort_title = __('Top votes');
                $sort_icon = "M50.25,340.54c-21,0-39.37-10.63-46.89-27.09-6.1-13.32-3.82-27.63,6.24-39.27L215.27,35.67c9.53-11.06,24.34-17.4,40.62-17.4S287,24.61,296.5,35.67l206.09,238.4c9.95,11.66,12.13,26,6,39.36-7.57,16.41-25.95,27-46.82,27h-73V285.76h22.81a9.4,9.4,0,0,0,8.61-5.32,8.34,8.34,0,0,0-1.34-9L263.19,91.07a9.92,9.92,0,0,0-7.28-3.24,9.73,9.73,0,0,0-7.06,3L93.08,271.49a8.31,8.31,0,0,0-1.33,9,9.4,9.4,0,0,0,8.61,5.34h22v54.72ZM350,493.73a39,39,0,0,0,38.81-39.15V285.82H327.68v146H183.33v-146h-61V454.58a39,39,0,0,0,38.81,39.15Z";
                break;
        }
        $hours_from--; // Because inside cases' loop, when the condition is false, we already increment it so we have to decrement it

        $threads = $threads->take(self::PAGESIZE);
        return view('explore')
            ->with(compact('forums'))
            ->with(compact('threads'))
            ->with(compact('hours_from'))
            ->with(compact('skip'))
            ->with(compact('sortby'))
            ->with(compact('sort_title'))
            ->with(compact('sort_icon'));
    }

    public function explore_more(Request $request) {
        $interval_increase_by = 12; // Hours
        $threads = collect([]);
        $indexes = $request->validate([
            'from'=>'required|numeric|max:2000',
            'to'=>'required|numeric|max:2000',
            'sortby'=>'sometimes|alpha-dash|max:200',
            'skip'=>'required|numeric|max:400'
        ]);
        $skip = $indexes['skip'];

        switch($indexes['sortby']) {
            case 'popular-and-recent':
                /**
                 * We use skip to check wether there's remaining in the previous interval
                 * The skip variable is only non-zero if there are remaining threads in the previous interval
                 */
                if($skip) {
                    /** Because there's remaining threads we keep the interval as it is */
                    $from = $indexes['from'];
                    $to = $indexes['to'];

                    /** Then we fetch all the remaining threads */
                    $threads = 
                        Thread::where('created_at', '<=', Carbon::now()->subHours($to)->toDateTimeString())
                        ->where('created_at', '>=', Carbon::now()->subHours($from)->toDateTimeString())
                        ->orderBy('view_count', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->get()
                        ->skip($skip);

                    if($threads->count() < self::FETCH_PAGESIZE) {
                        /**
                         * If the remaining threads are less than pagesize we need to do the following: 
                         * 1. fetch those remaining threads
                         * 2. calculate how many threads needed to fill the gap
                         * threads until we have pagesize threads Of course by doing that we have to change 
                         * the $from and $to and calculate the number to fill the gap
                         */
                        $to = $from;
                        $from = $from + $interval_increase_by;
                        $gap = self::FETCH_PAGESIZE - $threads->count(); // This is the number threads needed from the next interval
                        // Here we take gap from next interval
                        $temp = 
                            Thread::where('created_at', '<=', Carbon::now()->subHours($to)->toDateTimeString())
                            ->where('created_at', '>=', Carbon::now()->subHours($from)->toDateTimeString())
                            ->orderBy('view_count', 'desc')
                            ->orderBy('created_at', 'desc')
                            ->get()
                            ->take($gap);

                        while($temp->count() < self::FETCH_PAGESIZE) {
                            $temp = 
                                Thread::where('created_at', '<=', Carbon::now()->subHours($to)->toDateTimeString())
                                ->where('created_at', '>=', Carbon::now()->subHours($from)->toDateTimeString())
                                ->orderBy('view_count', 'desc')
                                ->orderBy('created_at', 'desc')
                                ->get();
                            $from++;
                        }
                        $from--;

                        $threads = $threads->concat($temp->take($gap));
                        $skip = $gap;
                    } else {
                        if($threads->count() == self::FETCH_PAGESIZE) {
                            /**
                             * Notice here that threads count equals to page size so we take $threads as it is and reset the
                             * values of skip to 0, and increase hours interval
                             * The reason why we increase range here and not in the next else, is because here we finish the interval
                             * by finding the remaining equals to page size wich means there no more threads in this interval
                             * Next else handle situation when remaining threads still greather than pagesize so we don't have to increase range
                             * because we will go bazck to that range next time
                             */
                            $skip = 0;
                            $to = $from;
                            $from = $from + $interval_increase_by;
                        } else {
                            /**
                             * If the remaining threads count is greather than pagesize we have to take only pagesize chunk
                             * and then increase skip value by adding pagesize to skip that range next time.
                             */
                            $threads = $threads->take(self::FETCH_PAGESIZE);
                            $skip = $skip + self::FETCH_PAGESIZE;
                        }
                    }

                } else {
                    // Define new range and this time between the old from and from-12 with interval of 12 hours
                    $to = $indexes['from'];
                    $from = $indexes['from'] + $interval_increase_by;
                    /**
                     * Here In case the range [from+12 -> from] doesn't reach pagesize we have to increase hours interval
                     * that's why we use this while loop.
                     * + 12 instead of - 12 because we are using subHours so to increase 
                     * the reange we have to add hours to be subtracted.
                     */
                    while($threads->count() < self::FETCH_PAGESIZE) {
                        $threads = 
                            Thread::where('created_at', '<=', Carbon::now()->subHours($to)->toDateTimeString())
                            ->where('created_at', '>=', Carbon::now()->subHours($from)->toDateTimeString())
                            ->orderBy('view_count', 'desc')
                            ->orderBy('created_at', 'desc')
                            ->get()
                            ->take(self::FETCH_PAGESIZE);
                        $from++;
                    }
                    $from--;

                    if($threads->count() > self::FETCH_PAGESIZE) {
                        /** 
                         * If the threads fetched from the new interval is greather than pagesize we simply give skip
                         * value of page size because this is the first chunk.
                         */
                        $skip = self::FETCH_PAGESIZE;
                    }
                }
                
                $payload = "";
                $count = 0;
                foreach($threads as $thread) {
                    $count++;
                    $thread_component = (new IndexResource($thread));
                    $thread_component = $thread_component->render(get_object_vars($thread_component))->render();
                    $payload .= $thread_component;
                }

                return [
                    "content"=>$payload,
                    'count'=>$count, // Number of threads (useful in appended threads events handlers)
                    "from"=>$from,
                    "to"=>$to,
                    'skip'=>$skip
                ];
                break;
            case 'replies-and-likes':
                if($skip) {
                    $from = $indexes['from'];
                    $to = $indexes['to'];

                    $threads = 
                        Thread::where('created_at', '<=', Carbon::now()->subHours($to)->toDateTimeString())
                        ->where('created_at', '>=', Carbon::now()->subHours($from)->toDateTimeString())
                        ->orderBy('created_at', 'desc')
                        ->get()
                        ->sortBy(function($thread) {
                            return -$thread->postsandlikescount;
                        })
                        ->skip($skip);

                    if($threads->count() < self::FETCH_PAGESIZE) {
                        $to = $from;
                        $from = $from + $interval_increase_by;
                        $gap = self::FETCH_PAGESIZE - $threads->count();

                        $temp = 
                            Thread::where('created_at', '<=', Carbon::now()->subHours($to)->toDateTimeString())
                            ->where('created_at', '>=', Carbon::now()->subHours($from)->toDateTimeString())
                            ->orderBy('created_at', 'desc')
                            ->get()
                            ->sortBy(function($thread) {
                                return -$thread->postsandlikescount;
                            })
                            ->take($gap);

                        while($temp->count() < self::FETCH_PAGESIZE) {
                            $temp = 
                                Thread::where('created_at', '<=', Carbon::now()->subHours($to)->toDateTimeString())
                                ->where('created_at', '>=', Carbon::now()->subHours($from)->toDateTimeString())
                                ->orderBy('created_at', 'desc')
                                ->get()
                                ->sortBy(function($thread) {
                                    return -$thread->postsandlikescount;
                                });
                            $from++;
                        }
                        $from--;

                        $threads = $threads->concat($temp->take($gap));
                        $skip = $gap;
                    } else {
                        if($threads->count() == self::FETCH_PAGESIZE) {
                            $skip = 0;
                            $to = $from;
                            $from = $from + $interval_increase_by;
                        } else {
                            $threads = $threads->take(self::FETCH_PAGESIZE);
                            $skip = $skip + self::FETCH_PAGESIZE;
                        }
                    }

                } else {
                    $to = $indexes['from'];
                    $from = $indexes['from'] + $interval_increase_by;
                    while($threads->count() < self::FETCH_PAGESIZE) {
                        $threads = 
                            Thread::where('created_at', '<=', Carbon::now()->subHours($to)->toDateTimeString())
                            ->where('created_at', '>=', Carbon::now()->subHours($from)->toDateTimeString())
                            ->orderBy('created_at', 'desc')
                            ->get()
                            ->sortBy(function($thread) {
                                return -$thread->postsandlikescount;
                            })
                            ->take(self::FETCH_PAGESIZE);
                        $from++;
                    }
                    $from--;

                    if($threads->count() > self::FETCH_PAGESIZE) {
                        $skip = self::FETCH_PAGESIZE;
                    }
                }
                
                $payload = "";
                $count = 0;
                foreach($threads as $thread) {
                    $count++;
                    $thread_component = (new IndexResource($thread));
                    $thread_component = $thread_component->render(get_object_vars($thread_component))->render();
                    $payload .= $thread_component;
                }

                return [
                    "content"=>$payload,
                    'count'=>$count,
                    "from"=>$from,
                    "to"=>$to,
                    'skip'=>$skip
                ];
                break;
            case 'votes':
                if($skip) {
                    $from = $indexes['from'];
                    $to = $indexes['to'];

                    $threads = 
                        Thread::where('created_at', '<=', Carbon::now()->subHours($to)->toDateTimeString())
                        ->where('created_at', '>=', Carbon::now()->subHours($from)->toDateTimeString())
                        ->orderBy('created_at', 'desc')
                        ->get()
                        ->sortBy(function($thread) {
                            return -$thread->votevalue;
                        })
                        ->skip($skip);

                    if($threads->count() < self::FETCH_PAGESIZE) {
                        /**
                         * If the remaining threads are less than pagesize we need to do the following: 
                         * 1. fetch those remaining threads
                         * 2. calculate how many threads needed to fill the gap
                         * threads until we have pagesize threads Of course by doing that we have to change 
                         * the $from and $to and calculate the number to fill the gap
                         */
                        $to = $from;
                        $from = $from + $interval_increase_by;
                        $gap = self::FETCH_PAGESIZE - $threads->count(); // This is the number threads needed from the next interval
                        // Here we take gap from next interval
                        $temp = 
                            Thread::where('created_at', '<=', Carbon::now()->subHours($to)->toDateTimeString())
                            ->where('created_at', '>=', Carbon::now()->subHours($from)->toDateTimeString())
                            ->orderBy('created_at', 'desc')
                            ->get()
                            ->sortBy(function($thread) {
                                return -$thread->votevalue;
                            })
                            ->take($gap);

                        while($temp->count() < self::FETCH_PAGESIZE) {
                            $temp = 
                                Thread::where('created_at', '<=', Carbon::now()->subHours($to)->toDateTimeString())
                                ->where('created_at', '>=', Carbon::now()->subHours($from)->toDateTimeString())
                                ->orderBy('created_at', 'desc')
                                ->get()
                                ->sortBy(function($thread) {
                                    return -$thread->votevalue;
                                });
                            $from++;
                        }
                        $from--;

                        $threads = $threads->concat($temp->take($gap));
                        $skip = $gap;
                    } else {
                        if($threads->count() == self::FETCH_PAGESIZE) {
                            /**
                             * Notice here that threads count equals to page size so we take $threads as it is and reset the
                             * values of skip to 0, and increase hours interval
                             * The reason why we increase range here and not in the next else, is because here we finish the interval
                             * by finding the remaining equals to page size wich means there no more threads in this interval
                             * Next else handle situation when remaining threads still greather than pagesize so we don't have to increase range
                             * because we will go bazck to that range next time
                             */
                            $skip = 0;
                            $to = $from;
                            $from = $from + $interval_increase_by;
                        } else {
                            /**
                             * If the remaining threads count is greather than pagesize we have to take only pagesize chunk
                             * and then increase skip value by adding pagesize to skip that range next time.
                             */
                            $threads = $threads->take(self::FETCH_PAGESIZE);
                            $skip = $skip + self::FETCH_PAGESIZE;
                        }
                    }

                } else {
                    // Define new range and this time between the old from and from-12 with interval of 12 hours
                    $to = $indexes['from'];
                    $from = $indexes['from'] + $interval_increase_by;
                    /**
                     * Here In case the range [from+12 -> from] doesn't reach pagesize we have to increase hours interval
                     * that's why we use this while loop.
                     * + 12 instead of - 12 because we are using subHours so to increase 
                     * the reange we have to add hours to be subtracted.
                     */
                    while($threads->count() < self::FETCH_PAGESIZE) {
                        $threads = 
                            Thread::where('created_at', '<=', Carbon::now()->subHours($to)->toDateTimeString())
                            ->where('created_at', '>=', Carbon::now()->subHours($from)->toDateTimeString())
                            ->orderBy('created_at', 'desc')
                            ->get()
                            ->sortBy(function($thread) {
                                return -$thread->votevalue;
                            })
                            ->take(self::FETCH_PAGESIZE);
                        $from++;
                    }
                    $from--;

                    if($threads->count() > self::FETCH_PAGESIZE) {
                        /** 
                         * If the threads fetched from the new interval is greather than pagesize we simply give skip
                         * value of page size because this is the first chunk.
                         */
                        $skip = self::FETCH_PAGESIZE;
                    }
                }
                
                $payload = "";
                $count = 0;
                foreach($threads as $thread) {
                    $count++;
                    $thread_component = (new IndexResource($thread));
                    $thread_component = $thread_component->render(get_object_vars($thread_component))->render();
                    $payload .= $thread_component;
                }

                return [
                    "content"=>$payload,
                    'count'=>$count, // Number of threads (useful in appended threads events handlers)
                    "from"=>$from,
                    "to"=>$to,
                    'skip'=>$skip
                ];
                break;
        }
    }
}
