<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Create Booking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">



                        <form method="POST" action="{{ route('admin.booking.store') }}" class="max-w-auto mx-auto">
                            @csrf
                            
                            <input type="hidden" name="id_schedule_user" id="id_schedule_user" value="{{$id}}">
                            <div class="mb-5">
                                <label for="type" class="block mb-2">Type</label>
                                <select name="type" id="type" required class="border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="meeting">Meeting</option>
                                <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="mb-5">
                                <label for="book_start" class="block mb-2">Start</label>
                                <input type="time" name="book_start" id="book_start" class="border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            </div>
                            
                            <div class="mb-5">
                                <label for="book_end" class="block mb-2">End</label>
                                <input type="time" name="book_end" id="book_end" class="border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            </div>

                            <button type="submit" class=" bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
                            <a href="{{ route('admin.booking.show', $id) }}" class="bg-white hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-slate-600 dark:hover:bg-slate-700 dark:focus:ring-slate-800">Cancel</a>
                        </form>


            </div>
        </div>
    </div>
</x-app-layout>