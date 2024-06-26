<div>

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3">
                <h1 class="h2 pb-4">Categorias</h1>
                <ul class="list-unstyled templatemo-accordion">
                    {{-- <li class="pb-3">
                        <a class="collapsed d-flex justify-content-between h3 text-decoration-none" href="#">
                            Gender
                            <i class="fa fa-fw fa-chevron-circle-down mt-1"></i>
                        </a>
                        <ul class="collapse show list-unstyled pl-3">
                            <li><a class="text-decoration-none" href="#">Men</a></li>
                            <li><a class="text-decoration-none" href="#">Women</a></li>
                        </ul>
                    </li>
                    <li class="pb-3">
                        <a class="collapsed d-flex justify-content-between h3 text-decoration-none" href="#">
                            Sale
                            <i class="pull-right fa fa-fw fa-chevron-circle-down mt-1"></i>
                        </a>
                        <ul id="collapseTwo" class="collapse list-unstyled pl-3">
                            <li><a class="text-decoration-none" href="#">Sport</a></li>
                            <li><a class="text-decoration-none" href="#">Luxury</a></li>
                        </ul>
                    </li> --}}
                    <li class="pb-3">
                        <a class="collapsed d-flex justify-content-between h3 text-decoration-none" href="#">
                            Categorias
                            <i class="pull-right fa fa-fw fa-chevron-circle-down mt-1"></i>
                        </a>
                        @if ($categorias)
                            <ul id="collapseThree" class="collapse list-unstyled pl-3">
                                @foreach ($categorias as $categoria)
                                    <li>
                                        <a class="text-decoration-none"
                                            href="{{ route('shop.all-products', ['category_id' => $categoria->id]) }}">
                                            {{ $categoria->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                </ul>
            </div>

            <div class="col-lg-9">
                <div class="row justify-content-end">
                    {{-- <div class="col-md-6">
                        <ul class="list-inline shop-top-menu pb-3 pt-1">
                            <li class="list-inline-item">
                                <a class="h3 text-dark text-decoration-none mr-3" href="#">All</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="h3 text-dark text-decoration-none mr-3" href="#">Men's</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="h3 text-dark text-decoration-none" href="#">Women's</a>
                            </li>
                        </ul>
                    </div> --}}
                    <div class="col-md-6 pb-4">
                        <div class="d-flex">
                            @if ($category_id != 0)
                                <button class="btn btn-secondary btn-sm me-2 w-50" wire:click='clearFilter'>
                                    <i class="fa fa-window-close" aria-hidden="true"></i>
                                    Limpar Filtro
                                </button>
                            @endif
                            <select class="form-control" wire:model='filter' wire:change='orderBy($event.target.value)'>
                                <option value="recent">Ordene pelos mais recentes</option>
                                <option value="antigo">Ordene pelos mais antigos</option>
                                <option value="atoz">Ordene de A a Z</option>
                                <option value="ztoa">Ordene Z a A</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @php
                        function minDesc($desc)
                        {
                            return substr($desc, 0, 50);
                        }
                    @endphp
                    @if ($produtos)
                        @foreach ($produtos as $produto)
                            <div class="col-md-4">
                                <div class="card mb-4 product-wap rounded-0">
                                    <div class="card rounded-0">
                                        <img class="card-img rounded-0 img-fluid" {{-- storage\app\public\01HRE4G4963GC4K9WQ0ZWWP5ZW.jpg --}}
                                            src="{{ '/storage/' . $produto->imagem }}">
                                        <div
                                            class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                            <ul class="list-unstyled">
                                                @if ($produto->likes()->where('produto_id', $produto->id)->first())
                                                    <li>
                                                        <span class="btn btn-primary text-white"
                                                            wire:click='likedProduto({{ $produto->id }})'>
                                                            <i class="fa fa-star"></i>
                                                        </span>
                                                    </li>
                                                @else
                                                    <li>
                                                        <span class="btn btn-primary text-white"
                                                            wire:click='likedProduto({{ $produto->id }})'>
                                                            <i class="far fa-star"></i>
                                                        </span>
                                                    </li>
                                                @endif
                                                <li><a class="btn btn-primary text-white mt-2"
                                                        href="{{ route('shop.single-product', $produto->id) }}"><i
                                                            class="far fa-eye"></i></a></li>
                                                <li>
                                                    <span class="btn btn-primary text-white mt-2"
                                                        wire:click='addProductInCart({{ $produto->id }})'>
                                                        <i class="fas fa-cart-plus"></i>
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <a href="shop-single.html"
                                            class="h3 text-decoration-none fw-bold">{{ $produto->nome }}</a>
                                        <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                            <li>{{ minDesc($produto->descricao) }}</li>
                                            {{-- <li>M/L/X/XL</li> --}}
                                            <li class="pt-2">
                                                <span
                                                    class="product-color-dot color-dot-red float-left rounded-circle ml-1"></span>
                                                <span
                                                    class="product-color-dot color-dot-blue float-left rounded-circle ml-1"></span>
                                                <span
                                                    class="product-color-dot color-dot-black float-left rounded-circle ml-1"></span>
                                                <span
                                                    class="product-color-dot color-dot-light float-left rounded-circle ml-1"></span>
                                                <span
                                                    class="product-color-dot color-dot-green float-left rounded-circle ml-1"></span>
                                            </li>
                                        </ul>
                                        {{-- <ul class="list-unstyled d-flex justify-content-center mb-1">
                                                <li>
                                                    <i class="text-warning fa fa-star"></i>
                                                    <i class="text-warning fa fa-star"></i>
                                                    <i class="text-warning fa fa-star"></i>
                                                    <i class="text-muted fa fa-star"></i>
                                                    <i class="text-muted fa fa-star"></i>
                                                </li>
                                            </ul> --}}
                                        <p class="text-center mb-0 mt-2 fw-bold">R$ {{ $produto->preco }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{ $produtos->links() }}
                    @endif


                </div>
                <div div="row">

                    {{-- <ul class="pagination pagination-lg justify-content-end">
                        <li class="page-item disabled">
                            <a class="page-link active rounded-0 mr-3 shadow-sm border-top-0 border-left-0"
                                href="#" tabindex="-1">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link rounded-0 mr-3 shadow-sm border-top-0 border-left-0 text-dark"
                                href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link rounded-0 shadow-sm border-top-0 border-left-0 text-dark"
                                href="#">3</a>
                        </li> --}}
                    </ul>
                </div>
            </div>

        </div>
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
        $wire.on('error', ($message) => {
            Swal.fire({
                title: "Atenção!",
                text: $message,
                icon: "error",
                footer: '<a href="/list-like" class="text-decoration-none">Veja seus favoritos!!</a>'
            });
        });
    </script>
@endscript
