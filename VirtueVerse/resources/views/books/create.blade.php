<head>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @vite('resources/js/shared/regexHelper.js')
</head>

<div>
    <h1 class="text-3xl font-bold underline">Hello book</h1>

    <div class="max-w-5xl p-4">
        <div class="mb-4">
            <input
                type="text"
                id="search-query"
                placeholder="Search for books"
                class="border rounded py-2 px-3 w-full"
            >
            <ul
                id="search-results"
                class="absolute left-0 mt-2 w-full bg-white border rounded shadow-md max-h-48 overflow-y-auto z-10"
            ></ul>
        </div>

        <!-- Book Creation Form -->
        <form action="{{ route('book.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="list-disc">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                    Title
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="title" name="title" type="text" placeholder="Title">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="author">
                    Author
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="author" name="author" type="text" placeholder="Author">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="publication-year">
                    Publication Year
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="publication-year" name="publication_year" type="number" placeholder="Publication Year">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                    Description
                </label>
                <textarea
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="description" name="description" placeholder="Description"></textarea>
            </div>

            <input type="hidden" name="open-library-key" id="open-library-key">
            <div class="flex items-center justify-between">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Create Book
                </button>
            </div>
        </form>
    </div>


</div>

<script>
</script>