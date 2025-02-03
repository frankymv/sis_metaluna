<?php

namespace App\Livewire\PowerGrid;

use App\Models\Cotizacion;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class CotizacionTable extends PowerGridComponent
{
    use WithExport;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Cotizacion::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('id')
            ->add('cliente.nombre_empresa')
            ->add('cliente.tipo_cliente')
            ->add('no_cotizacion')
            ->add('fecha_cotizacion_formatted', fn (Cotizacion $model) => Carbon::parse($model->fecha_cotizacion)->format('d/m/Y'))
            ->add('total_cotizacion')
            ->add('observaciones_cotizacion')
            ->add('forma_pago')
            ->add('cancelado')
            ->add('fecha_cancelado_formatted', fn (Cotizacion $model) => Carbon::parse($model->fecha_cancelado)->format('d/m/Y'))
            ->add('visible')
            ->add('sucursal_id')
            ->add('created_at');
    }

    public function columns(): array
    {
        return [

            Column::make('No cotizacion', 'no_cotizacion')
            ->sortable()
            ->searchable(),

            Column::make('Cliente id', 'cliente.nombre_empresa'),
            Column::make('Tipo Cliente', 'cliente.tipo_cliente')
            ->sortable()
            ->searchable(),


            Column::make('Fecha cotizacion', 'fecha_cotizacion_formatted', 'fecha_cotizacion')
                ->sortable(),

            Column::make('Total cotizacion', 'total_cotizacion')
                ->sortable()
                ->searchable(),

            Column::make('Observaciones cotizacion', 'observaciones_cotizacion')
                ->sortable()
                ->searchable(),

            Column::make('Forma pago', 'forma_pago')
                ->sortable()
                ->searchable(),

            Column::make('Cancelado', 'cancelado')
                ->sortable()
                ->searchable(),


            Column::make('Visible', 'visible')
                ->sortable()
                ->searchable(),

            Column::make('Sucursal id', 'sucursal_id'),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::datepicker('fecha_cotizacion'),
            Filter::datepicker('fecha_cancelado'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

    public function actions(Cotizacion $row): array
    {
        return [
            Button::add('exportar')
            ->slot('Exportar')
            ->id()
            ->class('bg-blue-500 hover:bg-blue-700 cursor-pointer text-white px-1 py-0.5 rounded text-sm')
            ->dispatch('exportarFila',['id'  => $row->id]),


        ];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
