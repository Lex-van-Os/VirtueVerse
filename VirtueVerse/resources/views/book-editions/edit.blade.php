@extends('app')

@section('content')
<head>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @vite('resources/js/bookEditions/bookEditionCombobox.js')
    @vite('resources/js/shared/regexHelper.js')
</head>

<h1 class="text-3xl font-bold underline">Edit book edition</h1>


<!-- Book edition Creation Form -->
<form action="{{ route('book-edition.update', $bookEdition->id) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
    @csrf
    @method('PUT') 

    @if ($errors->any())
        <x-forms.validation-errors :errors="$errors" />
    @endif

    <x-forms.combobox-input id="book" name="book" label="Book" :models="$books" idField="id" valueField="title"></x-forms.combobox-input>
    <x-forms.text-input type="text" id="title" label="Title" name="title" placeholder="Title" value="{{ $bookEdition->title }}" /> 
    <x-forms.text-input type="number" id="pages" label="Total pages" name="pages" placeholder="Pages" value="{{ $bookEdition->pages }}" />
    <x-forms.text-input type="text" id="isbn" label="ISBN number" name="isbn" placeholder="ISBN" value="{{ $bookEdition->isbn }}" />
    <x-forms.text-input type="number" id="publication-year" label="Publication year" name="publication-year" placeholder="Publication year" value="{{ $bookEdition->publication_year }}" />
    <x-forms.text-input type="text" id="language" label="Language" name="language" placeholder="Language" value="{{ $bookEdition->language }}" />

    <input type="hidden" name="book-id" id="book-id">
    <input type="hidden" name="editions-key" id="editions-key" v-model="editionsKey">

    <div class="flex items-center justify-between">
        <button
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
            type="submit">
            Update book edition
        </button>
    </div>
</form>

<script>
    var initialBookId = {{ $bookEdition->book_id }};


    function selectComboboxBook(initialId) {
        var combobox = document.getElementById('book');

        // Loop through the combobox options
        for (var i = 0; i < combobox.options.length; i++) {
            var option = combobox.options[i];
            
            // Check if the option's value matches the selected ID
            if (parseInt(option.value) === initialId) {
                // Set the option as selected
                option.selected = true;
                document.getElementById("book-id").value = initialId;
                break; // Stop looping once found
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        selectComboboxBook(initialBookId);
    });
</script>

@endsection
