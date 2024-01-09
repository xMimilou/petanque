{{-- resources/views/events/edit.blade.php --}}
@php
use Carbon\Carbon;
@endphp
<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
            <form action="{{ route('admin.events.update', $event->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nom de l'événement:</label>
                    <input type="text" name="name" id="name" value="{{ $event->name }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                    <textarea name="description" id="description" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $event->description }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Type d'événement:</label>
                    <input type="text" name="type" id="type" value="{{ $event->type }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label for="event_date" class="block text-gray-700 text-sm font-bold mb-2">Date de l'événement:</label>
                    <input type="datetime-local" name="event_date" id="event_date" value="{{ Carbon::parse($event->event_date)->format('d/m/Y H:i') }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label for="max_participants" class="block text-gray-700 text-sm font-bold mb-2">Nombre maximum de participants:</label>
                    <input type="number" name="max_participants" id="max_participants" value="{{ $event->max_participants }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Mettre à jour l'événement</button>
            </form>
        </div>
    </div>
</x-app-layout>