<?php

namespace App\Livewire;

use App\Models\Correntista;
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

final class CorrentistaTable extends PowerGridComponent
{
    use WithExport;
    public string $primaryKey = 'ruc_emisor';
    public string $sortField = 'ruc_emisor';


    public function setUp(): array
    {


        return [
           
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
{
    return Correntista::query()
        ->select(
            'ruc_emisor',
            'nombre_o_razon_social',
            'estado_del_contribuyente',
            'condicion_de_domicilio',
            'ubigeo',
            'tipo_de_via',
            'nombre_de_via',
            'codigo_de_zona',
            'tipo_de_zona',
            'numero',
            'interior',
            'lote',
            'dpto',
            'manzana',
            'kilometro',
            'distrito',
            'provincia',
            'departamento',
            'direccion_simple',
            'direccion',
            's_tabla02_tipodedocumentodeidentidad.DESCRIPCION as tipo_documento'
        )
        ->join('s_tabla02_tipodedocumentodeidentidad', 's_tabla02_tipodedocumentodeidentidad.N', '=', 'idt02doc');
}



    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('ruc_emisor')

            ->add('nombre_o_razon_social')
            ->add('estado_del_contribuyente')
            ->add('condicion_de_domicilio')
            ->add('ubigeo')
            ->add('tipo_de_via')
            ->add('nombre_de_via')
            ->add('codigo_de_zona')
            ->add('tipo_de_zona')
            ->add('numero')
            ->add('interior')
            ->add('lote')
            ->add('dpto')
            ->add('manzana')
            ->add('kilometro')
            ->add('distrito')
            ->add('provincia')
            ->add('departamento')
            ->add('direccion_simple')
            ->add('direccion')
            ->add('tipo_documento');
    }

    public function columns(): array
    {
        return [
            Column::make('Ruc emisor', 'ruc_emisor')
                
                ->searchable(),



            Column::make('Nombre o razon social', 'nombre_o_razon_social')
               
                ->searchable(),

            Column::make('Estado del contribuyente', 'estado_del_contribuyente')
              
                ->searchable(),

            Column::make('Condicion de domicilio', 'condicion_de_domicilio')
                
                ->searchable(),

            Column::make('Ubigeo', 'ubigeo')
              
                ->searchable(),

            Column::make('Tipo de via', 'tipo_de_via')
               
                ->searchable(),

            Column::make('Nombre de via', 'nombre_de_via')
                
                ->searchable(),

            Column::make('Codigo de zona', 'codigo_de_zona')
                
                ->searchable(),

            Column::make('Tipo de zona', 'tipo_de_zona')
                
                ->searchable(),

            Column::make('Numero', 'numero')
              
                ->searchable(),

            Column::make('Interior', 'interior')
                
                ->searchable(),

            Column::make('Lote', 'lote')
               
                ->searchable(),

            Column::make('Dpto', 'dpto')
              
                ->searchable(),

            Column::make('Manzana', 'manzana')
              
                ->searchable(),

            Column::make('Kilometro', 'kilometro')
               
                ->searchable(),

            Column::make('Distrito', 'distrito')
               
                ->searchable(),

            Column::make('Provincia', 'provincia')
               
                ->searchable(),

            Column::make('Departamento', 'departamento')
              
                ->searchable(),

            Column::make('Direccion simple', 'direccion_simple')
               
                ->searchable(),

            Column::make('Direccion', 'direccion')
               
                ->searchable(),

            Column::make('Tipo de documento de identidad', 'tipo_documento')
              
                ->searchable(),

        
        ];
    }

    public function filters(): array
    {
        return [
            // Filtro para RUC Emisor con inputText
            Filter::inputText('ruc_emisor')
                ->operators(['contains'])
                ->placeholder('Buscar RUC Emisor')
                ->builder(function (Builder $builder, $value) {
                    if (!empty($value['value'])) {
                        $builder->where('ruc_emisor', 'like', "%{$value['value']}%");
                    }
                }),
    
            // Filtro para Nombre o Razón Social con inputText
            Filter::inputText('nombre_o_razon_social')
                ->operators(['contains'])
                ->placeholder('Buscar Nombre o Razón Social')
                ->builder(function (Builder $builder, $value) {
                    if (!empty($value['value'])) {
                        $builder->where('nombre_o_razon_social', 'like', "%{$value['value']}%");
                    }
                }),
    
           
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
