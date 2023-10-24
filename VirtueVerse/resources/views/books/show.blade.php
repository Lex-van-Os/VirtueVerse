@extends('app')

@section('content')
<head>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @vite('resources/js/shared/regexHelper.js')
</head>

<h1 class="text-3xl font-semibold mb-6">Book Details</h1>
<div class="flex justify-center mt-8">

    <!-- Book image and actions -->
    <div class="w-1/4">
        <img src="{{ asset('book-template.png') }}" alt="Book Cover" class="w-full">
        
        <div class="mt-4 flex flex-col space-y-4">
            @if ($book->editions->isNotEmpty())
            <a href="{{ route('book-edition.catalogue', $book->id) }}" class="text-center bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">View editions</a>
            @endif

            @auth
                @if(Auth::user()->user_role_id === 1 || Auth::user()->user_role_id === 2)
                    <a href="{{ route('book-edition.create') }}" class="text-center bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">Create Book Edition</a>
                @endif
            @endauth

            @auth
                @if(Auth::user()->user_role_id === 1 || Auth::user()->user_role_id === 2 || (Auth::user()->user_role_id === 3 && $book->created_by === Auth::user()->id))
                    <a href="{{ route('book.edit', $book->id) }}" class="text-center bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">Edit Book information</a>
                @endif
            @endauth

        </div>
    </div>

    <!-- Book details -->
    <div class="w-3/4 ml-8">
        <!-- Book Title -->
        <h1 class="text-4xl font-semibold mb-1">{{ $book->title }}</h1>
        <p class="text-2xl font-normal text-gray-600 mb-8">{{ $book->author->name }}</p>
        <p class="mt-2">{{ $book->description }}</p>
        <div class="mt-4">
            <p class="text-sm mb-2 text-gray-600">Original publication year: {{ $book->publication_year }}</p>
            @if ($book->open_library_key)
                <p class="text-sm text-gray-600">Open Library Key: {{ $book->open_library_key }}</p>
            @endif
        </div>

        <!-- Author details -->
        <div class="mt-8 border-t pt-4">
            <h2 class="text-xl font-semibold">About the Author</h2>
            <p class="text-lg font-medium text-gray-600">{{ $book->author->name }}</p>
            <p class="mt-2">{{ $book->author->biography }}</p>
        </div>
    </div>
</div>
@endsection