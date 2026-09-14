@extends('layouts.app')

@section('title', 'ยินดีต้อนรับ')

@section('content')
    <h2>บทความล่าสุด</h2>
    <hr>
    @foreach ($blogs as $item)
    <h2>{{$item->title}}</h2>
    <p>{{ Str::limit(strip_tags($item->content), 100) }}</p>
    <a href="{{ route('detail', $item->id) }}" class="btn btn-primary">อ่านเพิ่มเติม</a> 

    <hr>
    @endforeach
    <hr>
@endsection
