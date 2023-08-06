<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Roles') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 pt-6">
        <div class="flex justify-end">
            <a href="{{ route('roles.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                New Role
            </a>
        </div>
    </div>

    @if (session()->has('status'))
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-green mt-4">
        <div class="bg-gray-800 border border-green-400 text-white px-4 py-4 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('status') }}</span>
        </div>
    </div>
    @endif

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="">

                    <section>

                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="border-b px-3 py-2">Name</th>
                                    <th class="border-b px-3 py-2">Description</th>
                                    <th class="border-b px-3 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $rol)
                                <tr>
                                    <td class="border-b px-3 py-2">{{ $rol->name }}</td>
                                    <td class="border-b px-3 py-2">{{ $rol->description }}</td>
                                    <td class="border-b px-3 py-2">
                                        @if($rol->id != 1)
                                        <div class="flex justify-center">
                                            <a href="{{ route('roles.edit', $rol->id) }}" class="ml-1 inline-flex items-center px-2 py-1 bg-gray-800 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none transition ease-in-out duration-150">
                                                Edit</a>
                                            <a href="{{ route('permissions.index', $rol->id) }}" class="ml-1 inline-flex items-center px-2 py-1 bg-gray-800 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none transition ease-in-out duration-150">
                                                Permissions</a>

                                            <!-- add delete action -->
                                            <form class="inline-block" action="{{ route('roles.destroy', $rol->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button type="submit" class="ml-1 inline-flex items-center px-2 py-1 bg-red-500 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-300 focus:bg-red-300 active:bg-red-700 focus:outline-none transition ease-in-out duration-150">Delete</button>
                                            </form>
                                        </div>
                                        @endif
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </section>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>