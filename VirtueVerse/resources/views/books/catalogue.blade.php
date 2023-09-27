<head>
    @vite('resources/css/app.css')
    @vite('resources/js/authors/author.js')
    @vite('resources/js/shared/regexHelper.js')
</head>

<div class="container mx-auto py-6">
    <h1 class="text-3xl font-semibold mb-6">Book Catalog</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($books as $book)
        <div class="bg-white rounded-lg shadow-md">
            <img src="{{ asset('book-template.png') }}" alt="{{ $book->title }}" class="w-full h-48 object-cover rounded-t-lg" />
            <div class="p-4">
                <h2 class="text-lg font-semibold mb-2">{{ $book->title }}</h2>
                <p class="text-gray-600">{{ $book->author }}</p>
                <p class="text-gray-400 italic mb-4">Original publication: {{ $book->publication_year }}</p>
                <p class="text-gray-700">{{ $book->description }}</p>
            </div>
            <div class="p-4 border-t border-gray-300">
                {{-- <a href="{{ route('book.show', $book->id) }}" class="text-blue-500 hover:underline">View Details</a> --}} 
            </div>
        </div>
        @endforeach
    </div>
</div>