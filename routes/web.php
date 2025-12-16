<?php

use App\Livewire\MemberList;
use App\Livewire\MeetingMinute;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Download Routes
Route::get('/downloads/member-list', MemberList::class)->name('members.list');
Route::get('/downloads/meeting-minute', MeetingMinute::class)->name('meeting.minute');