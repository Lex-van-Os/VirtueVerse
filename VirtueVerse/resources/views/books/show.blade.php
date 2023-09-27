<head>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @vite('resources/js/shared/regexHelper.js')
</head>

<div class="container mx-auto py-6">
    <h1 class="text-3xl font-semibold mb-6">Book Details</h1>
    <div class="flex justify-center mt-8">

        <!-- Book image and actions -->
        <div class="w-1/4">
            <img src="{{ asset('book-template.png') }}" alt="Book Cover" class="w-full">
            
            <div class="mt-4">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg mr-2">Create Book Edition</button>
                <button class="bg-green-500 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg">Create Study Traject</button>
            </div>
        </div>

        <!-- Book details -->
        <div class="w-3/4 ml-8">
            <!-- Book Title -->
            <h1 class="text-4xl font-semibold mb-1">{{ $book->title }}</h1>
            <p class="text-2xl font-normal text-gray-600 mb-8">{{ $book->author }}</p>
            <p class="mt-2">{{ $book->description }}</p>
            <div class="mt-4">
                <p class="text-sm mb-2 text-gray-600">Original Publish Year: {{ $book->publication_year }}</p>
                @if ($book->open_library_key)
                    <p class="text-sm text-gray-600">Open Library Key: {{ $book->open_library_key }}</p>
                @endif
            </div>

            <!-- Author details -->
            <div class="mt-8 border-t pt-4">
                <h2 class="text-xl font-semibold">About the Author</h2>
                <p class="text-lg font-medium text-gray-600">C.S. Lewis</p>
                <p class="mt-2">"Clive Staples Lewis was an Irish-born British novelist, academic, medievalist, literary critic, essayist, lay theologian and Christian apologist."</p>
            </div>
        </div>
    </div>
</div>