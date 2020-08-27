@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>

            @if ( !$posts->count() )
                <div class="card">
                    <div class="card-header">{{ __('Nothing') }}</div>
                    <div class="card-body">
                        There is no post till now. Login and write a new post now!!!
                    </div>
                </div>
            @else
                @foreach( $posts as $post )
                <div class="card mb-3">
                    @if ($post->image)
                        <img src="/images/{{ $post->image }}" class="card-img-top" alt="">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text">{{ $post->text }}</p>
                        <p class="card-text"><small class="text-muted">{{ $post->created_at }}</small></p>
                        @auth
                            @if (Auth::user()->can('edit article', $post))
                                <a href="#" class="card-link">Edit</a>
                                <a href="{{ route('delete-post', $post->id) }}" class="card-link">Delete</a>
                            @endif
                        @endauth
                    </div>
                </div>
{{--                        <div class="list-group">--}}
{{--                            <div class="list-group-item">--}}
{{--                                <h3><a href="{{ url('/'.$post->slug) }}">{{ $post->title }}</a>--}}
{{--                                    @if(!Auth::guest() && ($post->author_id == Auth::user()->id || Auth::user()->is_admin()))--}}
{{--                                        @if($post->active == '1')--}}
{{--                                            <button class="btn" style="float: right"><a href="{{ url('edit/'.$post->slug)}}">Edit Post</a></button>--}}
{{--                                        @else--}}
{{--                                            <button class="btn" style="float: right"><a href="{{ url('edit/'.$post->slug)}}">Edit Draft</a></button>--}}
{{--                                        @endif--}}
{{--                                    @endif--}}
{{--                                </h3>--}}
{{--                                <p>{{ $post->created_at->format('M d,Y \a\t h:i a') }} By <a href="{{ url('/user/'.$post->author_id)}}">{{ $post->author->name }}</a></p>--}}
{{--                            </div>--}}
{{--                            <div class="list-group-item">--}}
{{--                                <article>--}}
{{--                                    {!! Str::limit($post->body, $limit = 1500, $end = '....... <a href='.url("/".$post->slug).'>Read More</a>') !!}--}}
{{--                                </article>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    @endforeach
{{--                    {!! $posts->render() !!}--}}
            @endif
        </div>
    </div>
</div>
@endsection
