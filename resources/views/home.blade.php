@extends('layout')
@section('title', 'Home')
@section('content')
  <main>
    <div class="flex flex-col justify-center items-center">
      <div class="bg-blue-500 flex justify-center items-center w-full h-20">
        {{ ucwords($name[0] . " " . $name[1]) }}
      </div>
      <img src='@asset("favicon.svg")' alt="favicon">
      <div>
        {{--TODO: Handle forms and get the data from them--}}
        <form method="POST" action="" enctype="multipart/form-data">
          @csrf
          <input type="text" name="value" id="value">
          <input type="submit" name="" id="">
        </form>
      </div>
    </div>
  </main>
@endsection