<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Create Schedule') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">



                        <form method="POST" action="{{ route('admin.scheduleuser.store') }}" class="max-w-auto mx-auto">
                            @csrf

                            <div class="mb-5">
                                <label for="schedule_date" class="block mb-2">Date</label>
                                <input type="date" name="schedule_date" id="schedule_date" class="border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            </div>

                            <div class="mb-5">
                                <label for="id_user" class="block mb-2">User</label>
                                <select name="id_user" id="id_user" required class="border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @foreach($users as $user)
                                <option value="{{$user->id}}">{{ $user->name }}</option>
                                @endforeach 
                                </select>
                            </div>
                            
                            <div class="mb-5">
                                <label for="schedule_start" class="block mb-2">Available Start</label>
                                <input type="time" name="schedule_start" id="schedule_start" class="border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            </div>
                            
                            <div class="mb-5">
                                <label for="eating_schedule_start" class="block mb-2">Eating Start</label>
                                <input type="time" name="eating_schedule_start" id="eating_schedule_start" class="border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            </div>
                            
                            <div class="mb-5">
                                <label for="eating_schedule_end" class="block mb-2">Eating End</label>
                                <input type="time" name="eating_schedule_end" id="eating_schedule_end" class="border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            </div>                            

                            <div class="mb-5">
                                <label for="schedule_end" class="block mb-2">Available End</label>
                                <input type="time" name="schedule_end" id="schedule_end" class="border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            </div>

                            <button type="submit" class=" bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
                            <a href="{{ route('admin.scheduleuser.index') }}" class="bg-white hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-slate-600 dark:hover:bg-slate-700 dark:focus:ring-slate-800">Cancel</a>
                        </form>


            </div>
        </div>
    </div>
</x-app-layout>