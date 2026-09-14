@extends('layouts.app')

@section('title', $blog ? $blog->title : 'รายละเอียดบทความ')

@section('content')
<div class="container my-4" style="max-width: 860px;">
    <div class="card border-0 shadow-sm p-4 p-md-5">
        <h1 class="mb-3 text-center fw-bold">{{ $blog->title }}</h1>
        <hr class="mb-4">
        <div class="blog-detail-content" style="font-size: 1.1rem; line-height: 1.8;">
            {!! $blog->content !!}
        </div>
        <hr class="mt-4">
        <div class="text-center">
            <a href="/" class="btn btn-outline-secondary px-4">ย้อนกลับหน้าหลัก</a>
        </div>
    </div>
</div>
@endsection
