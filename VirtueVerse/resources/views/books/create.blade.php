@extends('app')

@section('content')
<head>
    @vite('resources/css/app.css')
    @vite('resources/css/customSelectize.css')
    @vite('resources/js/books/book.js')
    @vite('resources/js/shared/regexHelper.js')
</head>

<h1 class="text-3xl font-bold underline">Hello book</h1>

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
    
    <x-forms.text-input type="text" id="title" label="Title" name="title" placeholder="Title" />
    <x-forms.combobox-input id="author" name="author" label="Author" :models="$authors" idField="id" valueField="name"></x-forms.combobox-input>
    <x-forms.text-input type="number" id="publication-year" label="Publication year" name="publication-year" placeholder="Publication year" />
    <x-forms.textarea id="description" label="Description" name="description" placeholder="Description" />

    <input type="hidden" name="open-library-key" id="open-library-key">
    <input type="hidden" name="author-id" id="author-id">

    <div class="flex items-center justify-between">
        <button
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
            type="submit">
            Create Book
        </button>
    </div>
</form>

@endsection