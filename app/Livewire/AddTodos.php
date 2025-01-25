<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;

class AddTodos extends Component
{
    public $task = '';
    public $description = '';
    public $due_date = '';
    public $priority = '';

    public function add()
    {
        $this->validate([
            'task' => 'required|string',
            'description' => 'nullable|string|max:255',
        ]);

        Todo::create([
            'user_id' => Auth::id(),
            'task' => $this->task,
            'description' => $this->description,
            'due_date' => $this->due_date,
            'priority' => $this->priority ? $this->priority : 'Low',
            'status' => 'Pending',
        ]);

        $this->reset(['task', 'description', 'due_date', 'priority']);

        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.add-todo')->layout('layouts.app');
    }
}
