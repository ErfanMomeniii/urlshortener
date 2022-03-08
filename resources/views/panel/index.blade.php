
@extends('layout.layout')
@section('header')

<div class="px-3 py-2 bg-dark  text-white">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center ">

        <ul class="nav col-12 col-lg-auto my-2 justify-content-center text-align-center my-md-0 text-small">
          <li>
            <h1 class="nav-link text-white ">
              URL-SHORTENER
            </h1>
          </li>
        </ul>
      </div>
    </div>
  </div>
@endsection
@section('content')
<div class="p-5 d-flex justify-content-end align-items-center">
    <!-- Button trigger modal -->
<button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal">
ADD URL
</button>

<!-- Modal -->
@livewire('url-creater')
</div>

@livewire('url-redirecter')

@endsection
