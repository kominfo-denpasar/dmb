<?php

namespace App\DataTables;

use App\Models\Log;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class LogDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable
        ->addColumn('user_name', function($log){
            return $log->user->name ?? '-';
        })
        ->addColumn('aktivitas', function ($log) {
            return $log->description;
        })
        ->addColumn('action', 'logs.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Log $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Log $model)
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
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
                    // Enable Buttons as per your need
//                    ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            // 'log_name',
            'description',
            // ['data' => 'aktivitas', 'name' => 'aktivitas', 'title' => 'Aktivitas'],
            ['data' => 'user_name', 'name' => 'user_name', 'title' => 'User'],
            // 'role',
            'created_at',
            // 'subject_type',
            // 'event',
            // 'subject_id',
            // 'causer_type',
            // 'causer_id',
            // 'properties',
            // 'batch_uuid'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'logs_datatable_' . time();
    }
}
