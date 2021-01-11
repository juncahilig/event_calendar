<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Event, EventSchedule};

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $list=array();
        $month = date('m');
        $year = date('Y');
        $eventDetails = Event::first();
        $eventListSched = EventSchedule::select('date')->get()->toArray();
        for($d=1; $d<=31; $d++)
        {
            $time=mktime(12, 0, 0, $month, $d, $year);          
            if (date('m', $time)==$month)  
            // dd(date('Y-m-d', $time));
            // dd(array_search(date('Y-m-d', $time),  array_column($eventListSched, 'date')));
                $assignedEvent = array_search(date('Y-m-d', $time), array_column($eventListSched, 'date'));
                if($assignedEvent === false){
                    $event_title = " ";
                }else{
                    $event_title = $eventDetails->title;
                }
                $list[]=array(
                    'date'=> date('d D', $time),
                    'event'=> $event_title,
                    
                );

        }
        return $list;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $start = date("Y-m-d", strtotime($request->event['date_range']['start']."+1days" ));
        $end = date("Y-m-d", strtotime($request->event['date_range']['end']."+1days" ));
        Event::query()->truncate();
        $newEvent = new Event;
        $newEvent->title = $request->event["title"];
        $newEvent->date_from = $start;
        $newEvent->date_to = $end;
        $newEvent->days = json_encode($request->days);
        $newEvent->save();

        $days_difference = ((strtotime($end) - strtotime($start))/ 86400)+1;
        EventSchedule::query()->truncate();
        for($i=1 ; $i<= $days_difference; $i++){
            $index=0;
            $day = 0;
            $current_date = date("Y-m-d", strtotime($request->event['date_range']['start']."+".$i." days" ));
            $day = date('w', strtotime($current_date));
            $index = (int)$day - 1;
            if($index == -1){
                $index=6;
            }
            if($request->days[$index]['check']){
                $newEventSchedule = new EventSchedule;
                $newEventSchedule->event_id = $newEvent->id;
                $newEventSchedule->date = $current_date;
                $newEventSchedule->save();
            }
        }
        
        return $newEvent;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $eventUpdate = Event::find($id);

        if($eventUpdate){
            $eventUpdate->title = $request->event["title"];
            $eventUpdate->date_from = date("Y-m-d", strtotime($request->event["date_from"]));
            $eventUpdate->date_to = date("Y-m-d", strtotime($request->event["date_to"]));
            $eventUpdate->days = json_encode($request->event["days"]);
            $eventUpdate->save();
            return $eventUpdate;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
