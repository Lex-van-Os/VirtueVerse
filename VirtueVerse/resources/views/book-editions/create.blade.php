<head>
    @vite('resources/css/app.css')
    @vite('resources/js/bookEditions/bookEdition.js')
    @vite('resources/js/shared/regexHelper.js')
</head>

<div>
    <h1 class="text-3xl font-bold underline">Create book edition</h1>

    <div class="max-w-5xl p-4">
        <div class="mb-4">
            <input
                type="text"
                id="book-search-query"
                placeholder="Search for book"
                class="border rounded py-2 px-3 w-full"
            >
            <ul
                id="book-search-results"
                class="absolute left-0 mt-2 w-full bg-white border rounded shadow-md max-h-48 overflow-y-auto z-10"
            ></ul>
        </div>

        <div class="mb-4">
            <input
                type="text"
                id="book-edition-search-query"
                placeholder="Search for book edition"
                class="border rounded py-2 px-3 w-full"
            >
            <ul
                id="book-edition-search-results"
                class="absolute left-0 mt-2 w-full bg-white border rounded shadow-md max-h-48 overflow-y-auto z-10"
            ></ul>
        </div>

        <!-- Book edition Creation Form -->
        <form action="{{ route('book-edition.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
        
            @if ($errors->any())
                <x-forms.validation-errors :errors="$errors" />
            @endif
        
            {{-- Should be reworked into a dropdown and replace current search functionality --}}
            {{-- <x-forms.text-input type="text" id="book" label="Book" name="book" placeholder="Book" />  --}}
            <x-forms.text-input type="text" id="title" label="Title" name="title" placeholder="Title" /> 
            <x-forms.text-input type="number" id="pages" label="Total pages" name="pages" placeholder="Pages" />
            <x-forms.text-input type="text" id="isbn" label="ISBN number" name="isbn" placeholder="ISBN" />
            <x-forms.text-input type="number" id="publication-year" label="Publication year" name="publication-year" placeholder="Publication year" />
            <x-forms.text-input type="text" id="language" label="Language" name="language" placeholder="Language" />

            <input type="hidden" name="editions-key" id="editions-key">
            <input type="hidden" name="book-id" id="book-id">
        
            <div class="flex items-center justify-between">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Add book edition
                </button>
            </div>
        </form>
    </div>


</div>

<script>
</script>