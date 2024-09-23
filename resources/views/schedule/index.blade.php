<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-black leading-tight">
            {{ __('Schedule List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <div class="max-w-auto mx-auto">

                    <div class="mb-4">
                        <a href="{{ route('admin.scheduleuser.create') }}" class="bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Create Schedule User</a>
                        <a href="{{ route('admin.scheduleuser.create') }}" class="bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Book Date</a>
                    </div>

                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2  text-center">ID</th>
                                <th class="px-4 py-2 text-center">User</th>
                                <th class="px-4 py-2 text-center">Date</th>
                                <th class="px-4 py-2 text-center">Available Start</th>
                                <th class="px-4 py-2 text-center">Available End</th>
                                <th class="px-4 py-2 text-center">Eating Start</th>
                                <th class="px-4 py-2 text-center">Eating End</th>
                                <th class="px-4 py-2 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedules as $schedule)
                            <tr>
                                <td class="border px-4 py-2 text-center">{{ $schedule->id }}</td>
                                <td class="border px-4 py-2 text-center">{{ $schedule->user->name }}</td>
                                <td class="border px-4 py-2 text-center">{{ $schedule->schedule_date }}</td>
                                <td class="border px-4 py-2 text-center">{{ $schedule->available_start }}</td>
                                <td class="border px-4 py-2 text-center">{{ $schedule->available_end }}</td>
                                <td class="border px-4 py-2 text-center">{{ $schedule->eating_start }}</td>
                                <td class="border px-4 py-2 text-center">{{ $schedule->eating_end }}</td>

                                <td class="border px-4 py-2 text-center">
                                    <div class="flex justify-center">
                                        <a href="{{ route('admin.scheduleuser.date', $schedule->id) }}" class="bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Date</a>
                                        <button type="button" class="bg-pink-400 dark:bg-pink-600 hover:bg-pink-500 dark:hover:bg-pink-700 text-white font-bold py-2 px-4 rounded" onclick="confirmDelete('{{ $schedule->id }}')">Delete</button>

                                    </div>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    
    function confirmDelete(id) {
        alertify.confirm("¿Confirm delete record?",
        function(){
            let form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/admin/scheduleuser/' + id;
                    form.innerHTML = '@csrf @method("DELETE")';
                    document.body.appendChild(form);
                    form.submit();
            alertify.success('Ok');
        },
        function(){
            alertify.error('Cancel');
        });
    }

</script>