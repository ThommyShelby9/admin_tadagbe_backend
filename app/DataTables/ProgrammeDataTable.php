<?php

namespace App\DataTables;

use App\Models\Programme;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProgrammeDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $query->latest();

        return datatables()
            ->eloquent($query)
            ->addColumn('actions', function($model) {
                $action_list=[
                   // ["label"=>"Voir","route"=>route("programmes.show", $model->id),"method"=>"GET"],
                 //   ["label"=>"Modifier","route"=>route("programmes.edit", $model->id),"method"=>"GET"],
                    ["label"=>"Supprimer","route"=>route('programmes.destroy', $model->id),"method"=>"POST"]
                  ];
                  return view('shared.actions', compact('model','action_list'));
            })
            ->addColumn('courses', function($model) {
                $text="Le ". $model->date." \n";
               foreach( $model->courses as $course){
               $text=$text.$course->course." avec  ".$course->teacher." à ".$course->start_at." Durée: ".$course->duration." \n";
               }

                  return $text;
            })
            ;
           }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Programme $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Programme $model)
    {
        $query = $model->newQuery();
        $school_id = $this->request()->get('school_id');
        if ($school_id) {
            $query->where('school_id', $school_id);
        }

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('programme-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
            Column::make('id'),
            Column::make('date'),
            Column::make('school_id'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Programme_' . date('YmdHis');
    }
}
