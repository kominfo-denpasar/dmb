<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="blog-kategoris-table">
            <thead>
            <tr>
                <th>Judul</th>
                <th>Status</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($blogKategoris as $blogKategori)
                <tr>
                    <td>{{ $blogKategori->judul }}</td>
                    <td>{{ $blogKategori->status }}</td>
                    <td  style="width: 120px">
                        {!! Form::open(['route' => ['blog-kategoris.destroy', $blogKategori->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('blog-kategoris.edit', [$blogKategori->id]) }}"
                               class='btn btn-default btn-sm'>
                                <i class="far fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
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
            @include('adminlte-templates::common.paginate', ['records' => $blogKategoris])
        </div>
    </div>
</div>
