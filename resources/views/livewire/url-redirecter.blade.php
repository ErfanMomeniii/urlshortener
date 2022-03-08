<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}

    <div class="mt-5 d-flex justify-content-center align-items-center">

        <label >
        <input wire:model="shortUrl" name="shortUrl" type="search" class="form-control" placeholder="Short url" aria-label="Search">
        <br>
        <button wire:click="redirectToUrl" class="m-5 px-5 btn btn-primary align-items-center">Let's Go</button>
        </label>
        @yield('content')
    </div>
</div>
