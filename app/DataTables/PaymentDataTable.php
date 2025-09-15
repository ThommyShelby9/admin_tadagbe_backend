<?php

namespace App\DataTables;

use App\Models\Payment;
use App\Models\Admission;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
class PaymentDataTable extends DataTable
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
                    ["label"=>"Voir","route"=>route("payments.show", $model->id),"method"=>"GET"],
                    //["label"=>"Modifier","route"=>route("payments.edit", $model->id),"method"=>"GET"],
                   // ["label"=>"Supprimer","route"=>route('payments.destroy', $model->id),"method"=>"POST"]
                  ];
                  return view('shared.actions', compact('model','action_list'));
            }) 
            ->addColumn('status', function($model) {
            $status="En attente";
            $class="badge badge-warning";
            switch($model->status){
                case 0:
                    $status="Payement en attente";
                    $class="badge badge-warning";
                    break;
                case 1:
                    $status="Payé";
                    $class="badge badge-success";
                    break;
                case 2:
                    $status="Payement à vérifier";
                    $class="badge badge-info";
                    break;
                case 3:
                    $status="Validée";
                    $class="badge badge-success";
                    break;
                case 3:
                    $status="Rejeter";
                    $class="badge badge-danger";
                    break;
            }
                  return view('shared.status', compact('model','status','class'));
            })
            ->addColumn('name', function($model) {
            $name=$model->payer_type;
            switch($model->payer_type){
                case "admission":
                    $admission=Admission::find($model->payer_id);
                    $name=$admission?$admission->first_name." ".$admission->last_name:"";
                    break;
            }
                  return $name;
            }) 
            ->addColumn('reference', function($model) {
            return $model->reference_name;
            })
            ->addColumn('description', function($model) {
                return $model->reference_details;
            })
            ->addColumn('reference_code', function($model) {
                return $model->reference_code;
            });       
        }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Payment $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Payment $model)
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
                    ->setTableId('payment-table')
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
            Column::make('amount'),
            Column::make('payer_type'),
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
        return 'Payment_' . date('YmdHis');
    }
}
