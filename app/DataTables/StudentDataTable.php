<?php

namespace App\DataTables;

use App\Models\Student;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class StudentDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query) ->addColumn('actions', function($model) {
                $action_list=[
                    ["label"=>"Voir","route"=>route("students.show", $model->id),"method"=>"GET"],
                    ["label"=>"Supprimer","route"=>route('students.destroy', $model->id),"method"=>"POST"]
                  ];
                  return view('shared.actions', compact('model','action_list'));
            })
            ->addColumn('status', function($model) {
            $status="Inactif";
            $class="badge badge-warning";
            switch($model->status){
                case 0:
                    $status="Inactif";
                    $class="badge badge-warning";
                    break;
                case 1:
                    $status="Actif";
                    $class="badge badge-success";
                    break;
                case 2:
                    $status="Bloquée";
                    $class="badge badge-danger";
                    break;
                case 3:
                    $status="Renvoyé";
                    $class="badge badge-danger";
                    break;
            }
                  return view('shared.status', compact('model','status','class'));
            }) ->addColumn('first_name', function($model) {
                return $model->user->first_name;

            })->addColumn('last_name', function($model) {
                return $model->user->last_name;

            })->addColumn('email', function($model) {
                return $model->user->email;

            })->addColumn('phone', function($model) {
                return $model->user->phone;

            })
             ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Student $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Student $model)
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
                    ->setTableId('student-table')
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
            Column::make('school_id'),
            Column::make('id'),
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
        return 'Student_' . date('YmdHis');
    }
}
