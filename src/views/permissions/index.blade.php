<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permissions') }}
        </h2>
    </x-slot>

    <div class="py-12">

        @if (session()->has('status'))
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-green mb-4">
            <div class="bg-gray-800 border border-green-400 text-white px-4 py-4 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('status') }}</span>
            </div>
        </div>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                Manage Permissions
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                Select a role to manage its permissions.
                            </p>
                        </header>

                        <div class="mt-6 space-y-6">

                            <div>
                                <select name="roles" id="roles" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                    <option value="" <?= !is_null($rol->id) ? 'disabled' : '' ?>>Select a role...</option>
                                    @foreach ($roles as $role)
                                    <?php $selected = $rol->id == $role->id ? 'selected' : ''; ?>
                                    <option value="{{ $role->id }}" <?= $selected ?>>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>



                            <?php if (is_null($rol->id)) : ?>

                            <?php else : ?>

                                <form action="{{ route('permissions.store') }}" method="post">
                                    @csrf

                                    <input type="hidden" name="rol_id" value="{{ $rol->id }}">

                                    @foreach ($controllers as $controller => $methods)
                                    <div class="mt-6">
                                        <h2 class="text-2xl font-semibold">{{ $controller }}</h2>
                                        <ul>
                                            @foreach ($methods as $method)
                                            <li>
                                                <?php $checked = in_array($method['action'], $rol_permisions) ? 'checked' : ''; ?>
                                                <div class="flex items-center py-1">
                                                    <input type="checkbox" name="permissions[]" value="{{ $method['action'] }}" id="{{ $method['action'] }}" <?= $checked ?> class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                    <label for="{{ $method['action'] }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $method['name'] }}</label>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endforeach

                                    <div class="mt-6">
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            Save
                                        </button>
                                        <a href="{{ route('roles.index') }}" class="ml-2 inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-300 focus:bg-red-300 active:bg-red-900 transition ease-in-out duration-150" style="background-color: red;">{{ __('Cancel') }}</a>
                                    </div>

                                </form>

                            <?php endif ?>

                        </div>

                    </section>
                </div>
            </div>
        </div>

    </div>




    <script>
        document.getElementById('roles').addEventListener('change', function() {
            window.location.href = "<?= route('permissions.index') ?>" + "/" + this.value;
        });
    </script>

</x-app-layout>