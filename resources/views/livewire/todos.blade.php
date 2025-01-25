<div>
    <div class="mt-4 flex space-x-4">
        <input
            type="text"
            placeholder="Search tasks..."
            wire:model.live="search"
            class="block w-full bg-gray-800 text-white border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-400">

        <select wire:model.live="type"
            class="block w-full bg-gray-800 text-white border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="All">All</option>
            <option value="Pending">Pending</option>
            <option value="Completed">Completed</option>
        </select>
    </div>

    <ul class="mt-6 space-y-6">
        @foreach ($todos as $todo)
            <li class="p-6 rounded-lg shadow-md border border-gray-600"
                style="background-color: {{ $todo->status === 'Completed' ? '#013220' : '#1A202C' }}; color: {{ $todo->status === 'Completed' ? 'white' : 'inherit' }};">

                @if ($editTodoId === $todo->id)
                    <!-- Edit Mode -->
                    <div class="mb-4">
                        <input type="text" wire:model="task"
                            class="mt-1 block w-full bg-gray-800 text-white border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-400">
                    </div>
                    @error('task')
                        <span class="text-red-500 text-sm">{{ $task }}</span>
                    @enderror
                    <textarea wire:model="description"
                        class="mt-1 block w-full bg-gray-800 text-white border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-400"></textarea>
                    @error('description')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    <input type="date" wire:model="due_date"
                        class="mt-1 block w-full bg-gray-800 text-white border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                    <!-- Priority, Due Date, and Status -->
                    <div class="grid grid-cols-3 gap-4 mb-4">
                        <select wire:model="priority"
                            class="mt-1 block w-full bg-gray-800 text-white border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                        </select>
                        <select wire:model="status"
                            class="mt-1 block w-full bg-gray-800 text-white border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="Pending">Pending</option>
                            <option value="Completed">Completed</option>
                            <option value="In Progress">In Progress</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-4 flex space-x-4">
                        <button wire:click="save"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:ring focus:ring-green-500" style="background-color:green">
                            Save
                        </button>
                        <button wire:click="cancel"
                            class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 focus:ring focus:ring-gray-500" style="background-color:red">
                            Cancel
                        </button>
                    </div>
                @else
                    <!-- Display Mode -->
                    <div class="flex justify-between items-center mb-4">
                        <input
                            type="checkbox"
                            wire:click="toggleStatus({{ $todo->id }})"
                            {{ $todo->status === 'Completed' ? 'checked' : '' }}
                            class="mr-4 cursor-pointer w-5 h-5 bg-gray-800 text-indigo-600 border-gray-600 focus:ring-indigo-500">

                        <!-- Task Name -->
                        <h3 class="text-xl font-semibold {{ $todo->status === 'Completed' ? 'line-through' : '' }}">
                            {{ $todo->task }}
                        </h3>

                        <!-- Priority, Due Date, and Status -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-1 sm:space-y-0 sm:space-x-4">
                            <!-- Priority Badge -->
                            <span
                                class="px-4 py-1 rounded-full text-sm font-semibold text-white"
                                @if($todo->priority === 'Low') style="background-color: green;"
                                @elseif($todo->priority === 'Medium') style="background-color: blue;"
                                @elseif($todo->priority === 'High') style="background-color: red;"
                                @endif>
                                {{ $todo->priority }}
                            </span>

                            <!-- Due Date -->
                            <span class="text-sm font-medium text-gray-300">
                                <strong>Due Date:</strong> {{ $todo->due_date ? $todo->due_date : 'N/A' }}
                            </span>

                            <!-- Status -->
                            <span class="text-sm font-medium text-gray-300">
                                {{ $todo->status }}
                            </span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="text-sm">
                        <p><span class="font-semibold">Description:</span> {{ $todo->description }}</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 flex space-x-4">
                        <button
                            class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring focus:ring-indigo-500"
                            wire:click="edit({{ $todo->id }})" style="background-color:green">
                            Edit
                        </button>
                        <button
                            class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring focus:ring-red-500"
                            wire:click="delete({{ $todo->id }})">
                            Delete
                        </button>
                    </div>
                @endif
            </li>
        @endforeach
    </ul>
    <div class="mt-6">
        {{ $todos->links() }}
    </div>
</div>
