<div class="table-responsive">
    <table class="table" id="items-table">
        <thead>
            <tr>
                <th>Steamid</th>
        <th>Defid</th>
        <th>Quality</th>
        <th>Attributes</th>
        <th>Hash</th>
        <th>Slot</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->steamid }}</td>
            <td>{{ $item->defid }}</td>
            <td>{{ $item->quality }}</td>
            <td>{{ $item->attributes }}</td>
            <td>{{ $item->hash }}</td>
            <td>{{ $item->slot }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['items.destroy', $item->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('items.show', [$item->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('items.edit', [$item->id]) }}" class='btn btn-default btn-xs'>
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
