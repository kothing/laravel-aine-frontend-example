@extends('layout')

@section('content')
<!-- Posts Section -->
<section class="w-full md:w-2/3 flex flex-col items-center px-3">
	@foreach($posts as $post)
		<article class="w-full flex flex-col shadow my-4 rounded-md">
			<!-- Article Image -->
			@if(isset($post['cover-image']))
				<a href="/{{ $post['url'] }}" class="hover:opacity-75">
					<img src="{{ $post['cover-image']['thumb'] }}">
				</a>
			@endif
			<div class="flex flex-col justify-start p-6">
				<h1 class="text-3xl font-bold hover:text-gray-700 pb-4">
				   <a href="/{{ $post['url'] }}" class="hover:text-gray-700">
    				    {{ $post['title'] }}
    				</a> 
				</h1>
				<div class="text-sm pb-3">
				    <span>By <a href="/author/{{ @$post['author']['id'] }}"><strong>{{ @$post['author']['name'] }}</strong></a></span>,
				    <span>Published on {{ date('d M Y', strtotime($post['created_at'])) }}</span>,
				    <span>
				        @if(isset($post['category']))
        					<a href="/category/{{ $post['category']['url'] }}" class="text-blue-700 text-sm font-bold uppercase  hover:text-blue-400">
        						{{ $post['category']['title'] }}
        					</a>
        				@endif
				    </span>
				</div>
				<div class="pb-6">{{ @$post['excerpt'] }}</div>
				
				@if(isset($post['tags']))
					<div class="w-full">
					@foreach(@$post['tags'] as $tag)
						<a href="/tag/{{ $tag['tag'] }}" class="mr-2 mb-2 inline-block px-3 py-1 bg-gray-100 rounded-md hover:bg-gray-200">{{ $tag['tag'] }}</a>
					@endforeach
					</div>
					@endif
				<a href="/{{ $post['url'] }}" class="uppercase text-gray-800 hover:text-black mt-4">Continue Reading <i class="fas fa-arrow-right"></i></a>
			</div>
		</article>
	@endforeach

	<!-- Pagination -->
	<div class="flex items-center py-8">
		@for($i = 0 ; $i < $total_posts ; $i++)
			<a href="?page={{ $i+1 }}" class="h-10 w-10 bg-blue-800 hover:bg-blue-600 font-semibold text-white text-sm flex items-center justify-center ml-3">{{ $i+1 }}</a>
		@endfor
	</div>

</section>
@endsection