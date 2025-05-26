<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="masyarakats-table">
            <thead>
            <tr>
                <th>Nik</th>
                <th>Nama</th>
                <th>Tgl Lahir</th>
                <th>Alamat</th>
                <th>Hp</th>
                <th>Desa Id</th>
                <th>Kec Id</th>
                <th>User Id</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($masyarakats as $masyarakat)
                <tr>
                    <td>{{ $masyarakat->nik }}</td>
                    <td>{{ $masyarakat->nama }}</td>
                    <td>{{ $masyarakat->tgl_lahir }}</td>
                    <td>{{ $masyarakat->alamat }}</td>
                    <td>{{ $masyarakat->hp }}</td>
                    <td>{{ $masyarakat->desa_id }}</td>
                    <td>{{ $masyarakat->kec_id }}</td>
                    <td>{{ $masyarakat->user_id }}</td>
                    <td  style="width: 120px">
                        {!! Form::open(['route' => ['masyarakats.destroy', $masyarakat->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('masyarakats.show', [$masyarakat->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('masyarakats.edit', [$masyarakat->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $masyarakats])
        </div>
    </div>
</div>
