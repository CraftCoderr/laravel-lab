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
                        <p class="card-text">
                            @if ($post->user)
                                <b class="text-mutes">{{ $post->user->name }}</b>
                            @endif
                            <small class="text-muted">{{ $post->created_at }}</small>
                        </p>
                        @auth
                            @if (Auth::user()->can('edit article', $post))
                                <a href="{{ route('edit-post', $post->id) }}" class="card-link">Edit</a>
                                <a href="{{ route('delete-post', $post->id) }}" class="card-link">Delete</a>
                            @endif
                        @endauth
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
