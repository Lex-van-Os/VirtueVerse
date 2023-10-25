        <a href="/book/{{ $book->id }}" class="block bg-white rounded-lg shadow-md cursor-pointer">
            <img src="{{ asset('book-template.png') }}" alt="{{ $book->title }}" class="w-full h-48 object-cover rounded-t-lg" />
            <div class="p-4">
                <h2 class="text-lg font-semibold mb-2">{{ $book->title }}</h2>
                <p class="text-gray-600">{{ $book->author->name }}</p>
                <p class="text-gray-400 italic mb-4">Original publication: {{ $book->publication_year }}</p>
                <p class="text-gray-700">{{ Str::limit($book->description, 150) }}</p>
            </div>
            <div class="p-4 border-t border-gray-300">
                @php
                $createdDate = \Carbon\Carbon::parse($book->created_at);
                @endphp

                <p class="text-gray-400 text-sm italic">Created on: {{ $createdDate->format('d-m-Y') }}</p>
            </div>
        </a>