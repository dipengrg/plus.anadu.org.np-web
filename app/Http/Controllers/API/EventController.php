<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;
use App\Http\Responses\ApiResponse;

class EventController extends Controller
{
    // Get events
    public function getEvents(Request $request)
    {
        $events = Event::orderBy('scheduled_at', 'desc');

        if ($request->has('past') && $request->get('past') == true) {
            $events = $events->where('scheduled_at', '<', Carbon::now()->format('Y-m-d H:i:s'));
        }

        if ($request->has('page')) {
            $events = $events->paginate(10);
        } else {
            $events = $events->get();
        }

        return ApiResponse::success([
            'message' => __('event.listed'), 
            'data' => $events
        ]);
    }

    // Create event
    public function postEvent(Request $request)
    {
        $event = new Event;
        $event->type = $request->get('type');
        $event->title = $request->get('title');
        $event->scheduled_at = $request->get('scheduled_at');
        $event->save();

        return ApiResponse::success([
            'message' => __('event.created'), 
            'data' => $event
        ]);
    }

    // Get event details
    public function getActivity(Event $event)
    {
        return ApiResponse::success([
            'message' => __('event.view'), 
            'data' => $event
        ]);
    }

    // Update event
    public function updateEvent(Request $request, Event $event)
    {
        $event->type = $request->get('type');
        $event->title = $request->get('title');
        $event->summary = $request->get('summary');
        $event->scheduled_at = $request->get('scheduled_at');
        $event->remark = $request->get('remark');
        $event->save();

        return ApiResponse::success([
            'message' => __('event.updated'), 
            'data' => $event
        ]);
    }

    // Delete event
    public function deleteEvent(Event $event)
    {
        $event->delete();

        return ApiResponse::success([
            'message' => __('event.deleted'), 
            'data' => $event
        ]);
    }
}
