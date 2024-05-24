<div class="mb-4">
    {{-- <li class="list-group-item d-flex justify-content-between bg-body-tertiary mb-4">
        <div class="text-success">
            <h6 class="my-0">Promo code</h6>
            <small>EXAMPLECODE</small>
        </div>
        <span class="text-success">−$5</span>
    </li> --}}

    <form class="card p-2" wire:submit='applyCode'>
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Código de promoção" wire:model='code'>
            <button type="submit" class="btn btn-secondary">Aplicar</button>
        </div>
    </form>
</div>
