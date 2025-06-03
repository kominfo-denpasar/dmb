<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="pengaturans-table">
            <thead>
                <tr>
                    <th>Nama<th>
                </tr>
            </thead>
            <tbody>
            @foreach($pengaturans as $pengaturan)
                <tr>
                    <td colspan="2">
                        <div class='btn-group'>
                            <!-- <a href="{{ route('pengaturans.show', [$pengaturan->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a> -->
                            <a href="{{ route('pengaturans.edit', [$pengaturan->id]) }}"
                               class='btn btn-default btn-sm'>
                                <i class="far fa-edit"></i>
                            </a>
                            
                        </div>
                        <b>  - {{ $pengaturan->slug }}<b>
                        
                    </td>
                    <td>
                        
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $pengaturans])
        </div>
    </div>
</div>
