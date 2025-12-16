<?php

namespace App\Livewire;

use App\Models\Member;
use Livewire\Component;

class MeetingMinute extends Component
{
    public $organization;
    public $tenureMembers;
    public $members;

    // Initialize the component with organization and members data
    public function mount()
    {
        $this->organization = config('organization');
        $this->members = Member::where('status', 1)->orderBy('name', 'ASC')->get();
    }

    // Render the component view with a print layout
    public function render()
    {
        return view('livewire.meeting-minute')
            ->layout('components.layouts.print', ['title' => 'मिटिंङ्ग माईनुट']);
    }
}
