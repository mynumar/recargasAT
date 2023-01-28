<div>
    {{-- Success is as dangerous as failure. --}}
    <div class="card">
        <div class="card-header">
            <div class="text-right">
                <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#nueva"
                    wire:click="$set('busqueda', 'd-block')">
                    <i class="fas fa-eye"></i> Nueva atención
                </button>
            </div>
        </div>
        <div class="card-body">
            <table id="atenciones"class="table ">
                <thead>
                    <tr>
                        <td>Atención</td>
                        <td>Cliente</td>
                        <td>Canal</td>
                        <td>Fecha</td>
                        <td>Monto</td>
                        <td>Banco</td>
                        <td>Fecha de operación</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($atenciones as $atencione)
                        <tr>
                            <td>{{ $atencione->id }}</td>
                            <td>{{ $atencione->cliente->dni }}</td>
                            <td>{{ $atencione->medio->descripcion }}</td>
                            <td>{{ $atencione->fecha }}</td>
                            <td>{{ $atencione->deposito->monto }}</td>
                            <td>{{ $atencione->deposito->banco->descripcion }}</td>
                            <td>{{ $atencione->deposito->fecha }}</td>
                            <td><button class="btn btn-sm btn-link" data-toggle="modal" data-target="#nueva"
                                    wire:click="editar({{ $atencione }})">Editar</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="nueva" tabindex="-1" aria-labelledby="nuevaLabe"
        aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h5 class="modal-title" id="nuevaLabel">{{ $title }}</h5> --}}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="{{ $busqueda }}">
                        <p>Ingrese el número de celular del cliente:</p>
                        <input type="text" wire:model="celular" class="form-control form-sm-control">
                        <button wire:click="buscar()" class="btn btn-sm btn-info">Buscar</button>
                        @if (empty($cliente))
                            <p>No se encontró cliente ...</p>
                        @else
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Nombre: {{ $cliente->user->name . ' ' . $cliente->user->lastname }}</td>
                                        <td>DNI: {{ $cliente->dni }}</td>
                                        <td><button wire:click="atender()"
                                                class="btn btn-sm btn-success">Atender</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                    </div>

                    @if (!empty($cliente))

                        @if ($editando === false)
                            @if (empty($acceso))
                                <div class="">
                                    <div class="form-group">
                                        <p>Por seguridad esta acción requiere que ingrese su contraseña</p>
                                        <input type="password" class="form-control" wire:model.defer="pass">
                                    </div>
                                    <div class="form-group">
                                        <button wire:click="permitir" class="btn btn-sm btn-primary">Permitir</button>
                                    </div>
                                </div>
                            @else
                                <div class="">
                                    <div>
                                        <p>Indique el motivo a modificar la atención:</p>
                                        @foreach ($motivos as $motivo)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" wire:model="motivo"
                                                    value="{{ $motivo->id }}">
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    {{ $motivo->descripcion }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm btn-primary"
                                            wire:click="continuar">Continuar</button>
                                    </div>
                                </div>
                            @endif
                        @endif

                        <div class="{{ $atender }} row">
                            <div class="form-group col-12 text-center">
                                Cliente: <label for="" class="text-uppercase">
                                    {{ $cliente->user->name . ' ' . $cliente->user->lastname }}</label>
                            </div>
                            <div class="form-group col-12 ">
                                Atendido por: <span class="text-uppercase">
                                    {{ Auth::user()->name . ' ' . Auth::user()->lastname }}</span>
                            </div>
                            <div class="form-group col-12">
                                <label>Seleccione el canal de atención:</label><br>
                                @foreach ($medios as $medio)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" wire:model="medio"
                                            value="{{ $medio->id }}">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            {{ $medio->descripcion }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            {{-- <div class="form-group col-12">
                                <p class="font-weight-bold">DATOS DEL DEPÓSITO</p>
                            </div> --}}
                            <div class="form-group col-12">
                                <label for="">Seleccione la entidad bancaria</label>
                                <select class="custom-select form-select" wire:model="banco">
                                    <option selected>Open this select menu</option>
                                    @foreach ($bancos as $banco)
                                        <option value="{{ $banco->id }}">{{ $banco->descripcion }}</option>
                                    @endforeach
                                </select>
                                <span>{{ $ncuenta }}</span>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="">Monto a recargar</label>
                                    <input type="text" wire:model="monto" class="form-control form-sm-control"
                                        placeholder="100.00">
                                </div>
                                <div class="col-6">
                                    <label for="">Fecha de la transacción</label>
                                    <input type="date" wire:model="fecha" class="form-control form-sm-control">
                                </div>

                            </div>
                            <div class="form-group text-right">
                                <button type="button" wire:click="registrar"
                                    class="btn btn-sm btn-success">Registrar</button>
                            </div>
                        </div>

                    @endif
                    <div class="{{ $atendido }} text-center">
                        <h4 class="text-success text-center">
                            ¡HECHO! <br>
                            La atención ha sido regstrada y se ha modificado la billetera.
                        </h4>
                    </div>



                    {{-- </form> --}}
                </div>

            </div>
        </div>

    </div>

    <div wire:ignore.self class="modal fade" id="editar" tabindex="-1" aria-labelledby="editar" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editar">Editar atención</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                </div>
            </div>
        </div>
    </div>
</div>
