<div class="container">
    <div class="text-center mt-4">
        <h1>Olá, {{ auth()->user()->name }}. </h1>
        <p>Aqui está os items que você deixou como favorito no nosso site!</p>
    </div>
    <div class="mt-2 mb-5">
        @if (!$produtos)
            <div class="alert alert-danger ms-5 me-5 py-3" role="alert">
                <strong>Ops!</strong> Você ainda não tem produtos favoritados.
            </div>

            <div class="text-center">
                <a href="{{ route('shop.all-products') }}" class="btn btn-primary rounded-pill w-25">
                    <i class="fa fa-shopping-cart"></i>
                    Ir para a loja
                </a>
            </div>
        @else
            <ol class="list-group list-group-numbered">
                @foreach ($produtos as $produto)
                    <li class="list-group-item d-flex">

                        {{-- <div class="ms-2 me-auto justify-content-start "> --}}
                        <div class="me-auto">
                            <img src="{{ '/storage/' . $produto->imagem }}" alt="{{ $produto->nome }}" width="50px"
                                height="50px" class="rounded-circle float-start me-4">
                            <p class="fw-bold d-inline-block mt-3">{{ $produto->nome }}</p>
                        </div>
                        {{-- </div> --}}

                        <div class="justify-content-end mt-2">
                            <button class="btn btn-primary rounded-pill px-3 mb-1"
                                wire:click='addProductInCart({{ $produto->id }})'>
                                <i class="fa fa-cart-plus"></i>
                                Adicionar ao carrinho
                            </button>
                            <button class="btn btn-danger rounded-pill px-3 mb-1"
                                wire:click='remoteToFav({{ $produto->id }})'>
                                <i class="bi bi-heartbreak-fill"></i>
                                Remover dos favoritos
                            </button>
                        </div>
                        {{-- <span class="badge text-bg-primary rounded-pill">14</span> --}}
                    </li>
                @endforeach
            </ol>
            <div class="d-flex justify-content-end my-3">
                <a  href="{{ route('shop.all-products') }}" class="btn btn-primary w-25 me-2">
                    <i class="bi bi-bag-plus"></i>
                    Continuar comprando
                </a>
                <button class="btn btn-danger w-25" wire:click='removeAllFav'>
                    <i class="bi bi-trash3"></i>
                    Limpar todos os favoritos
                </button>
            </div>
        @endif


    </div>
</div>
@script
    <script>
        $wire.on('addToCart', ($message) => {
            Swal.fire({
                title: "Sucesso!",
                text: $message,
                icon: "success"
            });
        });
    </script>
@endscript
