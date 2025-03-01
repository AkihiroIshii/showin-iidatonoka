<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\EventTrait;

class EventController extends Controller
{
    use EventTrait;

    public function index() {
        $events = $this->getEvents();
        return view('event.index', compact('events'));
    }
}
