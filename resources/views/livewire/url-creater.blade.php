<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}

  <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Url creater</h5>
          <button wire:click="cancel" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <input wire:model="url" name="url" type="search" class="form-control" placeholder="..." aria-label="Search">
            @if($newShortUrl!=="")

            <span class="text-success">Your shorter url is <b>{{$newShortUrl}}</b></span>
            @endif

            @error('url') <span class="error text-danger">{{ $message }}</span> @enderror

        </div>
        <div class="modal-footer">
            <button wire:click="add" type="button" class="btn btn-success">Add</button>
          <button wire:click="cancel" type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>
