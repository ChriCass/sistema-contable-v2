<?php

namespace App\Livewire;

use App\Models\PlanContable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Session;
final class PlanContableTable extends PowerGridComponent
{   
     public $empresaId;
    public function setUp(): array
    {
       

        return [
         
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }
    public function datasource(): Builder
    {
        return PlanContable::query()
            ->when($this->empresaId, function ($query) {
                $query->where('id_empresas', $this->empresaId); 
            });
    }
  
    public function fields(): PowerGridFields
{
    return PowerGrid::fields()
        ->add('id')
     
        ->add('CtaCtable')
        ->add('Descripcion')
        ->add('Nivel')
        ->add('Dest1D')
        ->add('Dest1H')
        ->add('Dest2D')
        ->add('Dest2H')
        ->add('Ajust79')
        ->add('Esf')
        ->add('Ern')
        ->add('Erf')
        ->add('CC')
        ->add('Libro');
        
}

public function columns(): array
{
    return [
   
   
        Column::make('CtaCtable', 'CtaCtable')
            ->searchable()
           ,

        Column::make('Descripcion', 'Descripcion')
            ->searchable()
       ,

        Column::make('Nivel', 'Nivel')
            ->searchable()
         ,

        Column::make('Dest1D', 'Dest1D')
            ->searchable()
       ,

        Column::make('Dest1H', 'Dest1H')
            ->searchable()
     ,

        Column::make('Dest2D', 'Dest2D')
            ->searchable()
           ,

        Column::make('Dest2H', 'Dest2H')
            ->searchable()
       ,

        Column::make('Ajust79', 'Ajust79')
            ->searchable()
    ,

        Column::make('Esf', 'Esf')
            ->searchable()
         ,

        Column::make('Ern', 'Ern')
            ->searchable()
     ,

        Column::make('Erf', 'Erf')
            ->searchable()
    ,

        Column::make('CC', 'CC')
            ->searchable()
       ,

        Column::make('Libro', 'Libro')
            ->searchable()
     ,
     Column::action('Acciones')->visibleInExport(visible: false)
        
    ];
}

    public function filters(): array
    {
        return [
            Filter::inputText('name'),
            Filter::datepicker('created_at_formatted', 'created_at'),
        ];
    }

    
    public function actions(PlanContable $row): array
    {
        return [
            Button::add('view')
                ->slot('Editar')
                
                ->class('bg-teal-500 hover:bg-teal-700 text-white py-2 px-4 rounded disabled opacity-50 cursor-not-allowed')
           /*     ->route('apertura.edit', ['aperturaId' => $row->id] ),
                Button::add('edit')
                ->slot('Borrar')
                ->id()
                ->class('bg-red-500 hover:bg-red-700 text-white py-2 px-4 rounded')
                ->openModal('delete-apertura-principal-modal', ['aperturaId' => $row->id]) */
        ];
    }
}
