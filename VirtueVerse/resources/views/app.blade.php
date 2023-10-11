<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VirtueVerse</title>
</head>
<body>
    <!-- Navbar -->
    <nav class="bg-zinc-300 p-4">
        <div class="container mx-auto flex flex-wrap justify-between items-center">
            <div class="w-full lg:w-3/4 mb-4 lg:mb-0">
                <a href="/" class="text-black text-2xl font-bold">VirtueVerse</a>
            </div>
            <div class="w-full lg:w-1/4 space-x-16 flex items-center lg:justify-end">
                <a href="/home" class="text-black hover:underline">Home</a>
                <a href="/book-catalogue" class="text-black hover:underline">Book Catalogue</a>
                <div class="relative group">
                    <button @click="isOpen = !isOpen" class="text-black hover:underline group">
                        Create
                    </button>
                    <ul
                        x-show="isOpen"
                        @click.away="isOpen = false"
                        class="absolute mt-2 w-48 space-y-2 bg-zinc-100 text-gray-700 group-hover:block hidden"
                    >
                        <li><a href="/book-create" class="px-4 py-2">Create Book</a></li>
                        <li><a href="/book-edition-create" class="px-4 py-2">Create Book Edition</a></li>
                        <li><a href="/author-create" class="px-4 py-2">Create Author</a></li>
                    </ul>
                </div>
            </div>
            <div class="lg:hidden">
                <!-- Add a mobile menu button here if needed -->
            </div>
        </div>
    </nav>

    <!-- Content Container -->
    <div class="main-layout px-48 py-6">
        @yield('content') <!-- This is where your page content will be inserted -->

            <!-- Footer -->
    </div>

    <div class="footer-layout px-48 bg-zinc-300">
        <footer class="text-black py-8">
            <div class="container mx-auto flex flex-wrap justify-between">
                <div class="footer-left w-full lg:w-3/4 mb-4 lg:mb-0"> <!-- Adjusted width and added margin -->
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/2 lg:w-1/3 mb-6 lg:mb-0"> <!-- Adjusted class for Discover items -->
                            <h2 class="text-2xl font-semibold mb-4">About</h2>
                            <ul class="text-sm">
                                <li><a href="/about" class="hover:underline">About Us</a></li>
                                <li><a href="/privacy-policy" class="hover:underline">Privacy Policy</a></li>
                            </ul>
                        </div>
                        <div class="w-full md:w-1/2 lg:w-1/3 mb-6 lg:mb-0"> <!-- Adjusted class for Discover items -->
                            <h2 class="text-2xl font-semibold mb-4">Discover</h2>
                            <ul class="text-sm">
                                <li><a href="/books" class="hover:underline">Books</a></li>
                                <li><a href="/authors" class="hover:underline">Authors</a></li>
                                <li><a href="/editions" class="hover:underline">Book Editions</a></li>
                            </ul>
                        </div>
                        <div class="w-full md:w-1/2 lg:w-1/3">
                            <h2 class="text-2xl font-semibold mb-4">Get in Touch</h2>
                            <ul class="text-sm">
                                <li><a href="https://example.com" class="hover:underline" target="_blank">Portfolio</a></li>
                                <li><a href="https://github.com/yourusername" class="hover:underline" target="_blank">GitHub</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="footer-right w-full lg:w-1/4">
                    <p class="text-sm text-center lg:text-right">© VirtueVerse. All Rights Reserved.</p>
                </div>
            </div>
        </footer>
    </div>

</body>
</html>