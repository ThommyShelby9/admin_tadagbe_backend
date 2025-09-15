<?php

namespace App\DataTables;

use App\Models\Notes as Note;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class NotesDataTable extends DataTable
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
                    ["label"=>"Voir","route"=>route("notes.show", $model->id),"method"=>"GET"],
                    ["label"=>"Modifier","route"=>route("notes.edit", $model->id),"method"=>"GET"],
                   // ["label"=>"Supprimer","route"=>route('users.destroy', $model->id),"method"=>"POST"]
                  ];
                  return view('shared.actions', compact('model','action_list'));
            }) ;  
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Note $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Note $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('notes-table')
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
            Column::make('title'),
            Column::make('content'),
            Column::make('note_type'),
            Column::make('applies_to_date'),
            Column::make('users_id'),
            Column::make('status_id'),
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
        return 'Notes_' . date('YmdHis');
    }
}
