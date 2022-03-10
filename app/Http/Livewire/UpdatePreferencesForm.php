<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class UpdatePreferencesForm extends Component
{
    public $email_notifications;

    public User $user;

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function render()
    {
        $this->email_notifications = $this->user->email_notifications;

        return view('livewire.profile.update-preferences-form');
    }

    public function updatePreferences()
    {
        $this->user->forceFill([
            'email_notifications' => $this->email_notifications ? true : false,
        ])->save();

        $this->emit('saved');
    }
}
