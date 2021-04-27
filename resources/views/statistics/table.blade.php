<div class="table-responsive">
    <table class="table" id="statistics-table">
        <thead>
            <tr>
                <th>Target</th>
        <th>Progress</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($statistics as $statistic)
            <tr>
                <td>{{ $statistic->target }}</td>
            <td>{{ $statistic->progress }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['statistics.destroy', $statistic->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('statistics.show', [$statistic->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('statistics.edit', [$statistic->id]) }}" class='btn btn-default btn-xs'>
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
