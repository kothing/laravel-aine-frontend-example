@extends('layout')

@section('content')
<section class="w-full md:w-2/3 flex flex-col items-center px-3">
    <article class="flex flex-col shadow my-4 w-full">
        <div class="bg-white flex flex-col justify-start p-6">
            <h1 class="text-3xl font-bold hover:text-gray-700 pb-4 mt-4">{{ @$page['title'] }}</h1>
            <p class="pb-6">{!! @$page['content'] !!}</p>
        </div>
    </article>
</section>
@endsection