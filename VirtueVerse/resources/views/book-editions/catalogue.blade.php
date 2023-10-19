@extends('app')

@section('content')

<head>
    @vite('resources/css/app.css')
    @vite('resources/js/authors/author.js')
    @vite('resources/js/shared/regexHelper.js')
</head>

    <h1 class="text-3xl font-semibold mb-6">{{ $bookTitle }}: catalogue</h1>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($bookEditions as $bookEdition)
        <a href="{{ route('book-edition.show', $bookEdition->id) }}" class="block bg-white rounded-lg shadow-md cursor-pointer">
            <img src="{{ asset('book-template.png') }}" alt="{{ $bookEdition->title }}" class="w-full h-48 object-cover rounded-t-lg" />
            <div class="p-4">
                <h2 class="text-lg font-semibold mb-2">{{ $bookEdition->title }}</h2>
                <p class="text-gray-600">Publicated on: {{ $bookEdition->publication_year }}</p>
                @if ($bookEdition->isbn) 
                <p class="text-gray-600">ISBN number: {{ $bookEdition->isbn }}</p>
                @endif
                <p class="text-gray-600">Total pages: {{ $bookEdition->pages }}</p>
            </div>
            <div class="p-4 border-t border-gray-300">
                @php
                $createdDate = \Carbon\Carbon::parse($bookEdition->created_at);
                @endphp

                <p class="text-gray-400 text-sm italic">Created on: {{ $createdDate->format('d-m-Y') }}</p>
            </div>
        </a>
        @endforeach
    </div>

@endsection