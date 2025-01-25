<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Todo;
use Illuminate\Support\Collection;
use Livewire\WithPagination;

class Todos extends Component
{
    use WithPagination;
    public $search = '';
    public $task = '';
    public $editTodoId = null;
    public $description = '';
    public $due_date = '';
    public $priority = '';
    public $status = '';
    public $type = '';

    public function edit($id)
    {
        $this->editTodoId = $id;
        $todo = Todo::findOrFail($id);
        $this->task = $todo->task;
        $this->description = $todo->description;
        $this->due_date = $todo->due_date;
        $this->priority = $todo->priority;
        $this->status = $todo->status;
    }

    public function save()
    {
        $this->validate([
            'task' => 'required|string',
            'description' => 'nullable|string|max:255',
        ]);

        $todo = Todo::findOrFail($this->editTodoId);
        $todo->update([
            'task' => $this->task,
            'description' => $this->description,
            'due_date' => $this->due_date,
            'priority' => $this->priority,
            'status' => $this->status,
        ]);

        $this->reset(['task', 'description', 'due_date', 'priority', 'status', 'editTodoId']);
        $this->todos = auth()->user()->Todos()->get();
    }

    public function cancel()
    {
        $this->reset(['task', 'description', 'due_date', 'priority', 'status', 'editTodoId']);
    }

    public function delete($id)
    {
        $todo = Todo::find($id);

        if ($todo && $todo->user_id === auth()->id()) {
            $todo->delete();

            $this->todos = $this->todos->filter(fn ($item) => $item->id !== $id);
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleStatus($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->status = $todo->status === 'Completed' ? 'Pending' : 'Completed';
        $todo->save();
    }

    public function render()
    {
        $todos = Todo::where('user_id', auth()->id())
            ->when($this->search, function ($query) {
                $query->where('task', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->type && $this->type !== 'All', function ($query) {
                $query->where('status', $this->type);
            })
            ->orderByRaw("
                CASE
                    WHEN priority = 'High' THEN 1
                    WHEN priority = 'Medium' THEN 2
                    WHEN priority = 'Low' THEN 3
                    ELSE 4
                END
            ")->paginate(10);
        return view('livewire.todos', ['todos' => $todos]);
    }
}
