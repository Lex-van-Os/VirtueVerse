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
            <div class="w-full lg:w-3/5 mb-4 lg:mb-0">
                <a href="/" class="text-black text-2xl font-bold">VirtueVerse</a>
            </div>
            <div class="w-full lg:w-2/5 space-x-4 lg:space-x-8 flex items-center lg:justify-end">
                <a href="/" class="text-black hover:underline">Home</a>
                <a href="/book/catalogue" class="text-black hover:underline">Book Catalogue</a>
                <div class="relative group">
                    <button @click="isOpen = !isOpen" class="text-black hover:underline group">
                        Create
                    </button>
                    <ul
                        x-show="isOpen"
                        @click.away="isOpen = false"
                        class="absolute mt-2 w-48 sm:w-56 space-y-2 bg-zinc-100 text-gray-700 group-hover:block hidden"
                    >
                        <li><a href="/book/create" class="px-4 py-2">Create Book</a></li>
                        <li><a href="/book-edition/create" class="px-4 py-2">Create Book Edition</a></li>
                        <li><a href="/author/create" class="px-4 py-2">Create Author</a></li>
                    </ul>
                </div>
                <div class="flex space-x-4">
                    @guest
                        <a href="{{ route('login') }}" class="text-black hover:underline">Login</a>
                        <a href="{{ route('register') }}" class="text-black hover:underline">Register</a>
                    @endguest
                    @auth
                        <a href="{{ route('profile.edit') }}" class="text-black hover:underline">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="text-black hover:underline">Logout</a>
                        </form>
                    @endauth
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
                <div class="footer-left w-full lg:w-4/5 mb-4 lg:mb-0"> <!-- Adjusted width and added margin -->
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/2 lg:w-1/4 mb-6 lg:mb-0"> <!-- Adjusted class for Discover items -->
                            <h2 class="text-2xl font-semibold mb-4">About</h2>
                            <ul class="text-sm">
                                <li><a href="" class="hover:underline">About VirtueVerse</a></li>
                                <li><a href="" class="hover:underline">Privacy Policy</a></li>
                            </ul>
                        </div>
                        <div class="w-full md:w-1/2 lg:w-1/4 mb-6 lg:mb-0"> <!-- Adjusted class for Discover items -->
                            <h2 class="text-2xl font-semibold mb-4">Discover</h2>
                            <ul class="text-sm">
                                <li><a href="/book/catalogue" class="hover:underline">Books</a></li>
                                <li><a href="/author/create" class="hover:underline">Authors</a></li>
                                <li><a href="/book-edition/create" class="hover:underline">Book Editions</a></li>
                            </ul>
                        </div>
                        <div class="w-full md:w-1/2 lg:w-1/4">
                            <h2 class="text-2xl font-semibold mb-4">Get in Touch</h2>
                            <ul class="text-sm">
                                <li><a href="" class="hover:underline" target="_blank">Portfolio</a></li>
                                <li><a href="https://github.com/Lex-van-Os/VirtueVerse" class="hover:underline" target="_blank">GitHub</a></li>
                            </ul>
                        </div>
                        <div class="w-full md:w-1/2 lg:w-1/4">
                            <h2 class="text-2xl font-semibold mb-4">Profile</h2>
                            @guest
                                <ul class="text-sm">
                                    <li><a href="{{ route('login') }}" class="hover:underline">Login</a></li>
                                    <li><a href="{{ route('register') }}" class="hover:underline">Register</a></li>
                                </ul>
                            @endguest
                            @auth
                                <ul class="text-sm">
                                    <li><a href="{{ route('profile.edit') }}" class="hover:underline">My Profile</a></li>
                                </ul>
                            @endauth
                        </div>
                    </div>
                </div>
                <div class="footer-right w-full lg:w-1/5">
                    <p class="text-sm text-center lg:text-right">© VirtueVerse. All Rights Reserved.</p>
                </div>
            </div>
        </footer>
    </div>

</body>
</html>