<head>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @vite('resources/js/bookEditions/bookEdition.js')
    @vite('resources/js/shared/regexHelper.js')
</head>

<div>
    <h1 class="text-3xl font-bold underline">Create book edition</h1>

    <div class="max-w-5xl p-4">

        <!-- Book edition Creation Form -->
        <form action="{{ route('book-edition.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
        
            @if ($errors->any())
                <x-forms.validation-errors :errors="$errors" />
            @endif
        
            <x-forms.combobox-input id="book" name="book" label="Book" :models="$books" idField="id" valueField="title"></x-forms.combobox-input>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="book-edition">
                    Book Edition
                </label>

                <div class="relative">
                    <input
                      type="text"
                      id="book-edition-input"
                      placeholder="Search or select a book edition"
                      class="border rounded py-2 px-3 w-full cursor-pointer"
                    />
                    <ul
                      id="book-edition-dropdown"
                      class="absolute left-0 mt-2 w-full bg-white border rounded shadow-md max-h-48 overflow-y-auto z-10"
                    >
                      <!-- List items for editions go here -->
                      <!-- Example: -->
                      <!-- <li class="p-2 border-b hover:bg-gray-100 cursor-pointer">Edition 1</li> -->
                      <!-- <li class="p-2 border-b hover:bg-gray-100 cursor-pointer">Edition 2</li> -->
                    </ul>
                  </div>
            </div>

            <x-forms.text-input type="text" id="title" label="Title" name="title" placeholder="Title" /> 
            <x-forms.text-input type="number" id="pages" label="Total pages" name="pages" placeholder="Pages" />
            <x-forms.text-input type="text" id="isbn" label="ISBN number" name="isbn" placeholder="ISBN" />
            <x-forms.text-input type="number" id="publication-year" label="Publication year" name="publication-year" placeholder="Publication year" />
            <x-forms.text-input type="text" id="language" label="Language" name="language" placeholder="Language" />

            <input type="hidden" name="book-id" id="book-id">
            <input type="hidden" name="editions-key" id="editions-key" v-model="editionsKey">
        
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