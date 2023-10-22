@extends('app')

@section('content')

<head>
    @vite('resources/css/app.css')
    @vite('resources/js/bookEditions/bookEditionCatalogue.js')
    @vite('resources/js/components/dataControl/filterControl.js')
    @vite('resources/js/shared/regexHelper.js')
</head>

    <h1 class="text-3xl font-semibold mb-6" id="book-display-name">Book edition catalogue: {{ $bookTitle }}</h1>

    <div class="edition-catalogue-filters flex space-x-5">
        <x-data-control.filter-control name="book-filter" label="Book" model="book"></x-components.data-control.filter-control>
        <x-data-control.filter-control name="author-filter" label="Author" model="author"></x-components.data-control.filter-control>
        <x-data-control.input-control id="book-edition-search" label="book edition" model="book-edition"></x-components.data-control.filter-control>
    </div>
    
    <div id="book-editions" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($bookEditions as $bookEdition)
            <x-books.book-edition-card :bookEdition="$bookEdition" />
        @endforeach
    </div>

    <input type="hidden" id="selected-book-id" value="{{ $bookId }}" />
    <input type="hidden" contenteditable="true" id="filter-listener" />
@endsection