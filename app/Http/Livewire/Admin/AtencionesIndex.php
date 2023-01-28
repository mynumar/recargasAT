<?php

namespace App\Http\Livewire\Admin;

use App\Models\Atencione;
use App\Models\Banco;
use App\Models\Billetera;
use App\Models\Cliente;
use App\Models\Deposito;
use App\Models\Medio;
use App\Models\Motivo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AtencionesIndex extends Component
{
    public $editando;
    public $busqueda = "d-block";
    public $atender = "d-none";
    public $atendido = "d-none";
    // public $indicar = "d-block";
    public $acceso = false;
    public $medios;
    public $bancos;
    public $motivos;

    public $atencione_id;
    public $celular;
    public $medio;
    public $banco;
    public $monto;
    public $fecha;
    public $pass;
    public $motivo;

    public $cliente;
    public $ncuenta;

    public $atenciones;

    public function mount()
    {
        $this->medios = Medio::all();
        $this->bancos = Banco::all();
        $this->motivos = Motivo::all();

        $this->atenciones = Atencione::all();
    }

    public function updatedBusqueda()
    {
        $this->atendido = "d-none";
    }

    public function buscar()
    {
        $this->cliente = Cliente::where('celular', $this->celular)->first();
    }

    public function atender()
    {
        $this->busqueda = "d-none";
        $this->atender = "d-block";

        $this->reset(['celular']);
    }

    public function updatedBanco()
    {
        $this->ncuenta = "Número de cuenta:" . Banco::where('id', $this->banco)->first()->ncuenta;
    }
    public function registrar()
    {
        if ($this->atencione_id) {
            $atencione = Atencione::where('id', $this->atencione_id)->update([
                'medio_id' => $this->medio,
                'editado' => 1,
                'editado_por' => Auth::id(),
                'motivo_id' => $this->motivo
            ]);

            $deposito = Deposito::where('atencione_id', $this->atencione_id)->first();
            $old_monto = $deposito->monto;
            $deposito->monto = $this->monto;
            $deposito->banco_id = $this->banco;
            $deposito->fecha = $this->fecha;
            $deposito->save();

            if ($this->monto != $old_monto){
                $billetera = Billetera::where('cliente_id', $this->cliente->id)->first();
                $billetera->saldo -= $old_monto;
                $billetera->saldo += $this->monto;
                $billetera->save();
            }
           
        } else {
            $atencione = Atencione::create([
                'medio_id' => $this->medio,
                'cliente_id' => $this->cliente->id,
                'fecha' => date('Y-m-d H:m:s'),
                'atentido_por' => Auth::id()
            ]);

            $deposito = Deposito::create([
                'atencione_id' => $atencione->id,
                'monto' => $this->monto,
                'banco_id' => $this->banco,
                'fecha' => $this->fecha
            ]);

            $billetera = Billetera::where('cliente_id', $this->cliente->id)->first();
            $billetera->saldo += $this->monto;
            $billetera->save();
        }

        

        $this->atender = "d-none";
        $this->atendido = "d-block";

        $this->atenciones = Atencione::all();

        $this->reset(['cliente', 'medio', 'banco', 'monto', 'fecha', 'atencione_id', 'motivo']);
    }

    public function editar(Atencione $atencione)
    {
        $this->busqueda = "d-none";
        $this->atendido = "d-none";
        $this->editando = false;
        $this->cliente = $atencione->cliente;

        $this->atencione_id = $atencione->id;
        $this->medio = $atencione->medio_id;
        $this->banco = $atencione->deposito->banco_id;
        $this->monto = $atencione->deposito->monto;
        $this->fecha = $atencione->deposito->fecha;
    }

    public function permitir()
    {
        $this->acceso = Hash::check($this->pass, Auth::user()->password);
    }

    public function continuar()
    {
        $this->editando = true;        
        $this->atender = "d-block";

        $this->reset(['acceso', 'pass']);
    }

    public function render()
    {
        return view('livewire.admin.atenciones-index');
    }
}
