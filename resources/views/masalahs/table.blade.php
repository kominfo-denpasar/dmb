<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="masalahs-table">
            <thead>
            <tr>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($masalahs as $masalah)
                <tr>
                    <td>{{ $masalah->nama }}</td>
                    <td>{{ $masalah->deskripsi }}</td>
                    <!-- <td>{{ $masalah->status }}</td> -->
                    <td>
                        @if ((int) $masalah->status === 1)
                             <span class="badge bg-success">Aktif</span>
                        @elseif ((int) $masalah->status === 0)
                            <span class="badge bg-danger">Tidak Aktif</span>
                        @else
                            <span class="badge bg-secondary">-</span>
                        @endif
                    </td>
                    <!-- <td>
                        @if ($masalah->staus == 1)
                            <span class="badge bg-success">Aktif</span>
                        @elseif ($masalah->status == 0)
                            <span class="badge bg-danger">Tidak Aktif</span>
                        @else
                            <span class="badge bg-secondary">-</span>
                        @endif
                    </td> -->
                    <td  style="width: 120px">
                        {!! Form::open(['route' => ['masalahs.destroy', $masalah->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('masalahs.show', [$masalah->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('masalahs.edit', [$masalah->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $masalahs])
        </div>
    </div>
</div>
