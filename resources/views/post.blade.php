@extends('layout')

@section('content')
<section class="w-full md:w-2/3 flex flex-col items-center px-3">

    @if(isset($_SESSION['errors']))
        <div class="w-full bg-red-300 p-4">There are some errors in your form. Please fill all the fields and send the form again.</div>
        <?php unset($_SESSION['errors']) ?>
    @endif

    @if(isset($_SESSION['success']))
        <div class="w-full bg-green-300 p-4">Your comment has sent. After review it will be published.</div>
        <?php unset($_SESSION['success']) ?>
    @endif

    <article class="flex flex-col shadow my-4">
        <!-- Article Image -->
        @if(isset($post['cover-image']))
            <img src="{{ $post['cover-image']['thumb'] }}">
        @endif
        <div class="bg-white flex flex-col justify-start p-6">
            @if(isset($post['category']))
                <a href="/category/{{ $post['category']['url'] }}" class="text-blue-700 text-sm font-bold uppercase  hover:text-blue-400">
                    {{ $post['category']['title'] }}
                </a>
            @endif
            <div class="text-3xl font-bold hover:text-gray-700 pb-4 mt-4">{{ $post['title'] }}</div>
            <p class="text-sm pb-3">
            By <a href="/author/{{ @$post['author']['id'] }}"><strong>{{ @$post['author']['name'] }}</strong></a>, Published on {{ date('d M Y', strtotime($post['created_at'])) }}
            </p>
            
            <p class="mt-4">{!! $post['content'] !!}</p>
        </div>
    </article>

    <div class="w-full flex flex-col text-center md:text-left md:flex-row shadow bg-white mt-10 mb-10 p-6">
        <div class="w-32 h-32 flex justify-center md:justify-start mr-10 rounded-full overflow-hidden">
            @if(isset($post['author']['avatar']))
                <img src="{{ $post['author']['avatar']['thumb'] }}" class="object-cover">
            @endif
        </div>
        @if(isset($post['author']))
            <div class="flex-1 flex flex-col justify-center md:justify-start">
                <p class="font-semibold text-2xl"><a href="/author/{{ $post['author']['id'] }}">{{ $post['author']['name'] }}</a></p>
                <p class="pt-2">{{ $post['author']['info'] }}</p>
                <div class="flex items-center justify-center md:justify-start text-2xl no-underline text-blue-800 pt-4">
                    @if(isset($post['author']['facebook']))
                    <a class="" href="{{ $post['author']['facebook'] }}" target="_blank">
                        <i class="fab fa-facebook"></i>
                    </a>
                    @endif
                    @if(isset($post['author']['instagram']))
                    <a class="ml-4" href="{{ $post['author']['instagram'] }}" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                    @endif
                    @if(isset($post['author']['twitter']))
                    <a class="ml-4" href="{{ $post['author']['twitter'] }}" target="_blank">
                        <i class="fab fa-twitter"></i>
                    </a>
                    @endif
                    @if(isset($post['author']['linkedin']))
                    <a class="ml-4" href="{{ $post['author']['linkedin'] }}" target="_blank">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <div class="w-full text-center md:text-left md:flex-row shadow bg-white mt-4 mb-10 p-6">
        <p class="font-semibold text-2xl">Responses ({{count($comments)}})</p>

        @foreach($comments as $comment)
        <div class="w-full mt-8">
            <div class="font-bold"><i class="fas fa-user-alt text-green-200 mr-3"></i> {{ $comment['name'] }} <small class="font-normal">{{ date('d M Y', strtotime($comment['created_at'])) }}</small></div>
            <div class="pl-8">{{ $comment['comment'] }}</div>
        </div>
        @endforeach

        <div class="p-4 border border-gray-200 text-sm mt-10">
            <form method="post" action="/comment/{{ $post['id'] }}">
                <div class="w-full">
                    <label>Name</label>
                    <input name="name" type="text" class="w-full border border-gray-200 p-3">
                    
                    @if(isset($_SESSION['errors']['name']))
                    <p class="text-sm text-red-500">{{ $_SESSION['errors']['name'][0] }}</p>
                    @endif
                </div>
                <div class="w-full mt-2">
                    <label>E-mail</label>
                    <input name="email" type="text" class="w-full border border-gray-200 p-3">

                    @if(isset($_SESSION['errors']['e-mail']))
                    <p class="text-sm text-red-500">{{ $_SESSION['errors']['e-mail'][0] }}</p>
                    @endif
                </div>
                <div class="w-full mt-2">
                    <label>Your Response</label>
                    <textarea name="comment" class="w-full border border-gray-200 p-3"></textarea>
                    @if(isset($_SESSION['errors']['comment']))
                    <p class="text-sm text-red-500">{{ $_SESSION['errors']['comment'][0] }}</p>
                    @endif
                </div>
                <div class="w-1/4 mt-2">
                    <button type="submit" class="w-full border border-gray-200 p-3 bg-indigo-500 text-white">SEND</button>
                </div>
                <a name="comment"></a>
            </form>
        </div>
    </div>
</section>
@endsection