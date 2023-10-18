@extends('app')

@section('content')
<head>
    @vite('resources/css/app.css')
    @vite('resources/css/customSelectize.css')
    {{-- @vite('resources/js/books/book.js') --}}
    @vite('resources/js/books/bookCombobox.js')
    @vite('resources/js/shared/regexHelper.js')
</head>

<h1 class="text-3xl font-bold underline">Edit book</h1>

<!-- Book Edit Form -->
<form action="{{ route('book.update', $book->id) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
    @csrf
    @method('PUT') 

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="list-disc">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <x-forms.text-input type="text" id="title" label="Title" name="title" placeholder="Title" value="{{ $book->title }}" />
    <x-forms.combobox-input id="author" name="author" label="Author" :models="$authors" idField="id" valueField="name" value="{{ $book->author->name }}"></x-forms.combobox-input>
    <x-forms.text-input type="number" id="publication-year" label="Publication year" name="publication-year" placeholder="Publication year" value="{{ $book->publication_year }}" />
    <x-forms.textarea id="description" label="Description" name="description" placeholder="Description" value="{{ $book->description }}" />

    <input type="hidden" name="open-library-key" id="open-library-key">
    <input type="hidden" name="author-id" id="author-id">

    <div class="flex items-center justify-between">
        <button
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
            type="submit">
            Update Book
        </button>
    </div>
</form>

<script>
    var initialAuthorId = {{ $book->author->id }};


    function selectComboboxAuthor(initialId) {
        var combobox = document.getElementById('author');

        // Loop through the combobox options
        for (var i = 0; i < combobox.options.length; i++) {
            var option = combobox.options[i];
            
            // Check if the option's value matches the selected ID
            if (parseInt(option.value) === initialId) {
                // Set the option as selected
                option.selected = true;
                document.getElementById("author-id").value = initialId;
                break; // Stop looping once found
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        selectComboboxAuthor(initialAuthorId);
    });
</script>

@endsection