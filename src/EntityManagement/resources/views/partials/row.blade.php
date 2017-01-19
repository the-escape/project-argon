<tr class="table__page @if (!$row->getHasChildren()) table__page--inactive @endif @if ($row->getLevel() > 1) table__page--hidden @endif" data-id="{{ $row->getId() }}" data-parent="{{ $row->getParent() }}" data-level="{{ $row->getLevel() }}">
    @foreach ($columns as $key => $column)
        <td>
            @if ($key === 0)
                <a href="#" class="table__level @if ($row->getLevel() == 0) table__level--open @elseif ($row->getHasChildren()) table__level--collapsed @else table__level--end @endif" style="margin-left: {{ 20 * $row->getLevel() }}px">
            @endif
                <span>{!! @$row->getData($column->getName()) !!}</span>
            @if ($key === 0)
                </a>
            @endif
        </td>
    @endforeach
</tr>
<tr class="table__reveal" data-id="{{ $row->getId() }}">
    <td colspan="{{ count($columns) }}">
        <div class="table__page-attributes">
            <form class="page__create" action="{{ action('\Escape\Argon\EntityManagement\Http\Controllers\PageController@store') }}" method="POST">
                {{ csrf_field() }}
                <div class="form__group">
                    <label for="entity-type-{{ $row->getId() }}" class="sr-only">Entity Type</label>
                    <select name="type" id="entity-type-{{ $row->getId() }}" class="form__select" data-placeholder="Please select a page type">
                        <option value=""></option>
                        <option value="1">Generic</option>
                        <option value="2">Product</option>
                    </select>
                </div>
                <div class="form__group">
                    <label for="entity-name-{{ $row->getId() }}" class="sr-only">Entity Name</label>
                    <input name="name" id="entity-name-{{ $row->getId() }}" type="text" class="form__text" placeholder="Please enter a new page name" />
                </div>
                <button type="submit" class="form__btn">CREATE</button>
            </form>
            <button class="form__btn form__btn--small form__btn--grey table__reveal-cancel">CANCEL</button>
        </div>
    </td>
</tr>
