<?php

namespace App\DataTables;

use App\Models\Masyarakat;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class MasyarakatDataTable extends DataTable
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
        ->addColumn('action', 'masyarakats.datatables_actions')
        ->editColumn('status', function ($sql) {
            if ($sql->status == 0) {
                return "<span class='badge bg-danger'> Tidak Aktif </span>";
            } elseif ($sql->status == 1) {
                return "<span class='badge bg-success'> Aktif </span>";
            } else {
                return "-";
            }
        })
        ->rawColumns(['status', 'hp', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Masyarakat $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Masyarakat $model)
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
            'nama',
            'jk',
            // 'tgl_lahir' => [
            //     'title' => 'Tanggal Lahir',
            //     'data'  => 'tgl_lahir',
            //     'name'  => 'tgl_lahir',
            //     'render' => function ($data) {
            //         if ($data) {
            //             return\Carbon\Carbon::parse($data)->format('d/m/Y');
            //         } else {
            //             return '-';
            //         }
            //     }
            // ],
            'hp' => [
                'title' => 'No. HP',
                'data'  => 'hp',
                'name'  => 'hp',
            ],
            'email',
            'desa_id',
            'kec_id',
            'status'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'masyarakats_datatable_' . time();
    }
}
