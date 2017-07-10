<tr>
    @foreach ($columns as $column)
        <td>{!! @$row->getData($column->getName()) !!}</td>
    @endforeach
</tr>
