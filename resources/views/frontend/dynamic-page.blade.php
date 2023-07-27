@extends('frontend.master')

@section('content')
    <div class="max-w-screen-xl px-4 py-12 mx-auto space-y-8 overflow-hidden sm:px-6 lg:px-8 mt-5">
        {!! $page->content !!}
    </div>
@endsection
