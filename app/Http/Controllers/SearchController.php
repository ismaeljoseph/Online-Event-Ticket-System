<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

use App\Repositories\Contracts\EventRepoInterface;


class SearchController extends Controller
{
    protected $eventRepo;

    public function __construct(EventRepoInterface $eventRepo)
    {
        $this->eventRepo = $eventRepo;
    }
    public function __invoke(Request $request)
    {
        if ($request->has('q') && is_string($request->query('q'))) {
            $request->flashOnly('q');
            try{
                $events = $this->eventRepo->searchEvent($request->q, 6);
            } catch(\Exception $e) {
                Log::error($e->getMessage());
                return back()->with('error', 'Error connecting to Algolia Server');
            }
            
        } else {
            $events = [];
        }
        return view('search')->with(compact('events'));
    }
}
