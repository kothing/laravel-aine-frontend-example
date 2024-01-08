@extends('layout')

@section('content')
<!-- Posts Section -->
<section class="w-full md:w-2/3 flex flex-col items-center px-3">
	@foreach($posts as $po)
		<article class="w-full flex flex-col shadow my-4">
			<!-- Article Image -->
			@if(isset($po['cover-image']))
				<a href="/{{ $po['url'] }}" class="hover:opacity-75">
					<img src="{{ $po['cover-image']['thumb'] }}">
				</a>
			@endif
			<div class="bg-white flex flex-col justify-start p-6">
				@if(isset($po['category']))
					<a href="/category/{{ $po['category']['url'] }}" class="text-blue-700 text-sm font-bold uppercase  hover:text-blue-400">
						{{ $po['category']['title'] }}
					</a>
				@endif
				<a href="/{{ $po['url'] }}" class="text-3xl font-bold hover:text-gray-700 pb-4 mt-4">{{ $po['title'] }}</a>
				<p class="text-sm pb-3">
				By <a href="/author/{{ @$po['author']['id'] }}"><strong>{{ @$po['author']['name'] }}</strong></a>, Published on {{ date('d M Y', strtotime($po['created_at'])) }}
				</p>
				<a href="/{{ $po['url'] }}" class="pb-6">{{ @$po['excerpt'] }}</a>
				
				@if(isset($po['tags']))
					<div class="w-full">
					@foreach(@$po['tags'] as $tag)
						<a href="/tag/{{ $tag['tag'] }}" class="mr-2 mb-2 inline-block px-3 py-1 bg-gray-100 rounded-md hover:bg-gray-200">{{ $tag['tag'] }}</a>
					@endforeach
					</div>
					@endif
				<a href="/{{ $po['url'] }}" class="uppercase text-gray-800 hover:text-black mt-4">Continue Reading <i class="fas fa-arrow-right"></i></a>
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
