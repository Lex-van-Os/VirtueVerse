<head>
    @vite('resources/css/app.css')
    @vite('resources/js/authors/author.js')
    @vite('resources/js/shared/regexHelper.js')
</head>

<div>
    <h1 class="text-3xl font-bold underline">Create book edition</h1>

    <div class="max-w-5xl p-4">
        <div class="mb-4">
            <input
                type="text"
                id="search-query"
                placeholder="Search for authors"
                class="border rounded py-2 px-3 w-full"
            >
            <ul
                id="search-results"
                class="absolute left-0 mt-2 w-full bg-white border rounded shadow-md max-h-48 overflow-y-auto z-10"
            ></ul>
        </div>

        <!-- Author Creation Form -->
        <form action="{{ route('author.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
        
            @if ($errors->any())
                <x-forms.validation-errors :errors="$errors" />
            @endif
        
            <x-forms.text-input type="text" id="book" label="Book" name="book" placeholder="Book" />
            <x-forms.text-input type="text" id="title" label="Title" name="title" placeholder="Title" />
            <x-forms.text-input type="text" id="pages" label="Total pages" name="pages" placeholder="Pages" />
            <x-forms.text-input type="text" id="isbn" label="ISBN number" name="isbn" placeholder="ISBN" />
            <x-forms.text-input type="text" id="publication-year" label="Publication year" name="publication_year" placeholder="Publication year" />
            <x-forms.text-input type="text" id="language" label="Language" name="language" placeholder="Language" />
            <x-forms.textarea id="biography" label="Biography" name="biography" placeholder="Biography" />

            <input type="hidden" name="open-library-key" id="open-library-key">
        
            <div class="flex items-center justify-between">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Add author
                </button>
            </div>
        </form>
    </div>


</div>

<script>
</script>