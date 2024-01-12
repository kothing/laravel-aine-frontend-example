<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ @$blog_info['pagetitle'] }}</title>
    <meta name="description" content="">

    <link rel="icon" type="image/svg+xml" href="{{ config('app.url') . '/favicon.svg'}}">

    <!-- Tailwind -->
    <link href="{{config('app.url').'/vendor/tailwindcss/tailwind@2.2.19-lite.min.css'}}" rel="stylesheet">

    <!-- AlpineJS -->
    <!--<script src="{{config('app.url').'/vendor/alpinejs/alpine@2.8.2.js'}}" defer></script>-->

    <!-- Font Awesome -->
    <!--<script src="{{config('app.url').'/vendor/font-awesome/font-awesome@5.13.0-all.min.js'}}"></script>-->
</head>
<body class="bg-white font-family-karla">

    <!-- Top Bar Nav -->
    <nav class="w-full py-4 bg-blue-800 shadow">
        <div class="w-full container mx-auto flex flex-wrap items-center justify-between">

            <ul class="flex items-center justify-between font-bold text-sm text-white uppercase no-underline">
                <li><a class="hover:text-gray-200 hover:underline px-4" href="/">Home</a></li>    
                @foreach($pages as $pa)
                    @if($pa['menu-position'] == 'MainMenu' || $pa['menu-position'] == 'Both')
                        <li><a class="hover:text-gray-200 hover:underline px-4" href="/page/{{ $pa['url'] }}">{{ $pa['title'] }}</a></li>
                    @endif
                @endforeach
            </ul>

            <div class="flex items-center text-lg no-underline text-white pr-6">
                
            </div>
        </div>

    </nav>

    <!-- Text Header -->
    <header class="w-full container mx-auto">
        <div class="flex flex-col items-center py-12">
            <a class="font-bold text-gray-800 uppercase hover:text-gray-700 text-5xl" href="/">
                {{ @$blog_info['name'] }}
            </a>
            <p class="text-lg text-gray-600">
                {{ @$blog_info['description'] }}
            </p>
        </div>
    </header>

    <!-- Topic Nav -->
    <nav class="w-full py-4 border-t border-b bg-gray-100" x-data="{ open: false }">
        <div class="block sm:hidden">
            <a
                href="#"
                class="block md:hidden text-base font-bold uppercase text-center flex justify-center items-center"
                @click="open = !open"
            >
                Topics <i :class="open ? 'fa-chevron-down': 'fa-chevron-up'" class="fas ml-2"></i>
            </a>
        </div>
        <div :class="open ? 'block': 'hidden'" class="w-full flex-grow sm:flex sm:items-center sm:w-auto">
            <div class="w-full container mx-auto flex flex-col sm:flex-row items-center justify-center text-sm font-bold uppercase mt-0 px-6 py-2">
                @foreach($categories as $cat)
                    <a href="/category/{{ $cat['url'] }}" class="hover:bg-gray-400 rounded py-2 px-4 mx-2 @if(@$url == $cat['url']) bg-gray-400 @endif">{{ $cat['title'] }}</a>
                @endforeach
            </div>
        </div>
    </nav>


    <div class="container mx-auto flex flex-wrap py-6">

        @yield('content')

        <!-- Sidebar Section -->
        <aside class="w-full md:w-1/3 flex flex-col items-center px-3">
            <div class="w-full shadow flex flex-col my-4 p-6 rounded-md">
                <p class="text-xl font-semibold pb-5">About Us</p>
                <p class="pb-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas mattis est eu odio sagittis tristique. Vestibulum ut finibus leo. In hac habitasse platea dictumst.</p>
                <a href="/page/about" class="w-full bg-blue-800 text-white font-bold text-sm uppercase rounded hover:bg-blue-700 flex items-center justify-center px-2 py-3 mt-4">
                    Get to know us
                </a>
            </div>
            
            <div class="w-full shadow my-4 p-6 rounded-md">
                <p class="text-xl font-semibold pb-5">Tags</p>
                @foreach($tags as $ta)
                    <a href="/tag/{{ $ta['tag'] }}" class="mr-2 mb-2 inline-block px-3 py-1 bg-gray-100 rounded-md hover:bg-gray-200">{{ $ta['tag'] }}</a>
                @endforeach
            </div>
        </aside>
    </div>

    <footer class="w-full border-t bg-white">
        <div class="w-full container mx-auto flex flex-col items-center">
            <div class="flex flex-col md:flex-row text-center md:text-left md:justify-between py-6">
                @foreach($pages as $pa)
                    @if($pa['menu-position'] == 'FooterMenu' || $pa['menu-position'] == 'Both')
                        <a href="/page/{{ $pa['url'] }}" class="uppercase px-3">{{ $pa['title'] }}</a>
                    @endif
                @endforeach
            </div>
            <div class="uppercase pb-6">{{ @$blog_info['copyright'] }}</div>
            <div class="pb-6">
                <label>Globals fields: </label>
                <span>
                    @foreach($globals_info as $g)
                    <span>{{$g}}</span>
                    @endforeach
                </span>
            </div>
        </div>
    </footer>

</body>
</html>