<x-guest-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="mx-auto">
                @if(Auth::user())
                    <form method="POST" action="/urls">
                        @csrf
                        <input type="text"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                               placeholder="">

                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-2"
                                type="submit">
                            Shorten Url
                        </button>
                    </form>
                @endif
                <x-table :items="$urls"></x-table>
            </div>
        </div>
    </div>
</x-guest-layout>
