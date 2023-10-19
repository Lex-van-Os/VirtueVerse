@extends('app')

@section('content')
<head>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @vite('resources/js/shared/regexHelper.js')
</head>

<h1 class="text-3xl font-semibold mb-6">Book edition details</h1>
<div class="flex justify-center mt-8">

    <div class="w-1/4">
        <img src="{{ asset('book-template.png') }}" alt="Book Cover" class="w-full">
        
        <div class="mt-4 flex flex-col space-y-4">
            <button class="text-center bg-green-500 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg">Create Study Traject</button>

            <a href="{{ route('book.show', $bookEdition->book->id) }}" class="text-center bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">View book details</a>

            @if(Auth::user()->user_role_id === 1 || Auth::user()->user_role_id === 2 || (Auth::user()->user_role_id === 3 && $bookEdition->created_by === Auth::user()->id))
                <a href="{{ route('book-edition.edit', $bookEdition->id) }}" class="text-center bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">Edit edition information</a>
            @endif

        </div>
    </div>

    <div class="w-3/4 ml-8">
        <h1 class="text-4xl font-semibold mb-1">{{ $bookEdition->title }}</h1>
        <p class="text-2xl font-normal italic">{{ $bookEdition->book->title }}</p>
        <p class="mb-8 text-gray-400 italic">By: {{ $bookEdition->book->author->name }}</p>
        <p class="mt-2">{{ $bookEdition->description }}</p>
        <div class="mt-4">
            <p class="text-sm mb-2 text-gray-600">Edition pubication year: {{ $bookEdition->publication_year }}</p>
            @if ($bookEdition->isbn) 
                <p class="text-sm mb-2 text-gray-600">ISBN number: {{ $bookEdition->isbn }}</p>
            @endif
            <p class="text-sm mb-2 text-gray-600">Total pages: {{ $bookEdition->pages }}</p>
            @if ($bookEdition->book->open_library_key)
            <p class="text-sm text-gray-600">Book Open Library Key: {{ $bookEdition->book->open_library_key }}</p>
        @endif
        </div>

        <div class="mt-8 border-t pt-4">
            <h2 class="text-xl font-semibold">About the book</h2>
            <p class="text-lg italic font-normal">{{ $bookEdition->book->title }}</p>
            <p class="mt-2">{{ $bookEdition->book->description }}</p>
        </div>
    </div>
</div>
@endsection