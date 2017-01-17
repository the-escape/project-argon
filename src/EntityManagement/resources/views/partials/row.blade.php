<tr class="table__page @if ($row->getLevel() > 1) table__page--hidden @endif" data-id="{{ $row->getId() }}" data-parent="{{ $row->getParent() }}" data-level="{{ $row->getLevel() }}">
    @foreach ($columns as $key => $column)
        <td>
            @if ($key === 0)
                <a class="table__level table__level--collapsed" style="margin-left: {{ 20 * $row->getLevel() }}px"></a>
            @endif
            <span>{!! @$row->getData($column->getName()) !!}</span>
        </td>
    @endforeach
</tr>
<tr class="table__reveal" data-id="{{ $row->getId() }}">
    <td colspan="{{ count($columns) }}">
        <div class="table__page-attributes">
            <label for="entity-name-{{ $row->getId() }}" class="sr-only">Entity Name</label>
            <input id="entity-name-{{ $row->getId() }}" type="text" class="form__text" placeholder="Please enter a new page name" />
            <button type="submit" class="form__btn">CREATE</button>
        </div>
    </td>
</tr>
