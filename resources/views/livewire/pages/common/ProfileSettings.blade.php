<?php

namespace App\Livewire\Pages\Common;

use Livewire\Component;

class ProfileSettings extends Component
{
    public function connectCalender()
    {
        dd('LIVEWIRE OK');
        return redirect()->route('google.calendar.connect');
    }

    public function disconnectCalender()
    {
        auth()->user()->accountSetting()->update([
            'google_access_token' => null,
            'google_calendar_info' => null,
        ]);

        session()->flash('success', true);
    }

    public function render()
    {
        return view('livewire.pages.common.profile-settings');
    }
}

