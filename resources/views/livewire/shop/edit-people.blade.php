<div class="container">
    <div class="py-5 text-center">
        {{-- <img class="d-block mx-auto mb-4" src="/public/assets/img/favicon.ico" alt="" width="72" height="57"> --}}
        <h2>Edição de perfil</h2>
        <p class="lead">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Reprehenderit nemo adipisci aliquid beatae est?
            Totam, vero qui nulla temporibus sed molestias odit ad explicabo, ea fuga inventore velit obcaecati quam.
        </p>
    </div>

    <div class="row g-5">


        <div class="col-lg-12 mb-5">

            <h4 class="mb-3">Informações necessárias</h4>
            <form class="needs-validation" wire:submit='editPeople'>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="firstName" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="firstName" required wire:model='nome'>
                        @error('nome')
                            <div class="text-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label for="lastName" class="form-label">Sobrenome</label>
                        <input type="text" class="form-control" id="lastName" placeholder="" required
                            wire:model='sobrenome'>
                        @error('sobrenome')
                            <div class="text-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>



                    {{-- <div class="col-12">
                        <label for="email" class="form-label">Email <span
                                class="text-body-secondary">(Optional)</span></label>
                        <input type="email" class="form-control" id="email" placeholder="you@example.com">
                        <div class="invalid-feedback">
                            Please enter a valid email address for shipping updates.
                        </div>
                    </div> --}}

                    <div class="col-12">
                        <label for="address" class="form-label">Endereço</label>
                        <input type="text" class="form-control" id="address" placeholder="1234 Main St" required
                            wire:model='endereco'>
                        @error('endereco')
                            <div class="text-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="cpf" class="form-label">CPF</label>
                        <input type="text" class="form-control" id="cpf" placeholder="000.000.000-00" required
                            wire:model='cpf'>
                        @error('cpf')
                            <div class="text-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="zip" class="form-label">CEP</label>
                        <input type="" id="zip" name="cep" maxlength="8" pattern="[0-9]{8}"
                            class="form-control" placeholder="15530000" required wire:model.live='cep'
                            wire:change="atualizarCep">
                        @error('cep')
                            <div class="text-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="col-md-4">
                        <label for="cidade" class="form-label">Cidade</label>
                        <input type="text" class="form-control" id="cidade" disabled wire:model.live='cidade'>

                    </div>

                    <div class="col-md-4">
                        <label for="estado" class="form-label">Estado</label>
                        <input type="text" class="form-control" id="estado" disabled wire:model.live='estado'>
                    </div>
                    <div class="col-md-4">
                        <label for="bairro" class="form-label">Bairro</label>
                        <input type="text" class="form-control" id="bairro" disabled wire:model.live='bairro'>
                    </div>

                </div>


                {{-- <hr class="my-4"> --}}
                <div class="d-flex justify-content-center my-5">
                    <button class="w-25 btn btn-primary btn-lg me-1" type="submit" wire:loading.attr="disabled">
                        Salvar
                    </button>
                    <a class="w-25 btn btn-secondary btn-lg ms-1" href="{{ route('shop.cart') }}">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>
@script
    <script>
        $wire.on('enviado', ($message) => {
            Swal.fire({
                title: "Sucesso!",
                text: $message,
                icon: "success"
            }).then(() => {
                window.location.href = '/cart';
            })
        });
        $wire.on('error', ($message) => {
            Swal.fire({
                title: "Erro!",
                text: $message,
                icon: "error"
            });
        });
    </script>
@endscript
