<?php

namespace App\DataTables;

use App\Models\Admission;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AdmissionDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
       // dd($query);
       $query->latest();
        return datatables()
            ->eloquent($query)
            ->addColumn('actions', function($model) {
                $action_list=[
                    ["label"=>"Voir","route"=>route("admissions.show", $model->id),"method"=>"GET"],
                    ["label"=>"Supprimer","route"=>route('admissions.destroy', $model->id),"method"=>"POST"]
                  ];
                  if($model->payment()&&$model->payment()->status!==1)
                  array_push($action_list,["label"=>"Payer","route"=>route("admissions.pay", $model->id),"method"=>"GET"]);
                  return view('shared.actions', compact('model','action_list'));
            })
            ->addColumn('status', function($model) {
            $status="En attente";
            $class="badge badge-warning";
            switch($model->status){
                case 0:
                    $status="En attente";
                    $class="badge badge-warning";
                    break;
                case 1:
                    $status="Validée";
                    $class="badge badge-success";
                    break;
                case 2:
                    $status="En traitement";
                    $class="badge badge-secondary";
                    break;
                case 3:
                    $status="Rejeter";
                    $class="badge badge-danger";
                    break;
            }
                  return view('shared.status', compact('model','status','class'));
            }) ;
        }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Admission $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
/**
 * Get query source of dataTable.
 *
 * @param \App\Models\Admission $model
 * @return \Illuminate\Database\Eloquent\Builder
 */
public function query(Admission $model)
{
    $query = $model->newQuery();

    // Filtres existants
    $school_id = $this->request()->get('school_id');
    $status = $this->request()->get('status');

    // Nouveaux filtres
    $first_name = $this->request()->get('first_name');
    $last_name = $this->request()->get('last_name');
    $email = $this->request()->get('email');
    $phone = $this->request()->get('phone');
    $paiement_mode = $this->request()->get('paiement_mode');
    $nationality = $this->request()->get('nationality');
    $date_from = $this->request()->get('date_from');
    $date_to = $this->request()->get('date_to');

    // Application des filtres
    if ($school_id) {
        $query->where('school_id', $school_id);
    }
    if ($status !== null && $status !== '') {
        $query->where('status', $status);
    }
    if ($first_name) {
        $query->where('first_name', 'like', "%{$first_name}%");
    }
    if ($last_name) {
        $query->where('last_name', 'like', "%{$last_name}%");
    }
    if ($email) {
        $query->where('email', 'like', "%{$email}%");
    }
    if ($phone) {
        $query->where('phone', 'like', "%{$phone}%");
    }
    if ($paiement_mode) {
        $query->where('paiement_mode', $paiement_mode);
    }
    if ($nationality) {
        $query->where('nationality', 'like', "%{$nationality}%");
    }
    if ($date_from) {
        $query->whereDate('created_at', '>=', $date_from);
    }
    if ($date_to) {
        $query->whereDate('created_at', '<=', $date_to);
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
                    ->setTableId('admission-table')
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
            Column::make('status'),
            Column::make('study_path_id'),
            Column::make('first_name'),
            Column::make('last_name'),
            Column::make('phone'),
            Column::make('email'),
            Column::make('school_id'),
            Column::make('paiement_mode'),
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
        return 'Admission_' . date('YmdHis');
    }
}
