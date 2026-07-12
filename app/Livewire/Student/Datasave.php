<?php

namespace App\Livewire\Student;

use App\Services\SlotBookingService;
use Livewire\Component;

class MaterialApoyo extends Component
{
    public $student;
    public $slotBookings ;
    public $selectedBookingId;
    public function mount()
    {
        $this->student = Auth()->user();
        $this->slotBookings = (new SlotBookingService())->getStudentUpcomingTutorias();
        dd($this->slotBookings);
    }


    public function selectBooking($idBooking)
    {
        $this->selectedBookingId = $idBooking;
    }


    public function render()
    {
        return view('livewire.student.material-apoyo')->layout('layouts.app');
    }
}
