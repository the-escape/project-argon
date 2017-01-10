<div class="actions actions--large">
    <div class="form__group">
        <input type="text" class="form__text icon" placeholder="Search">
        <span class="icon search"></span>
    </div>
    <div class="actions__right">
        <a href="#" class="form__btn form__btn--small">CREATE</a>
    </div>
</div>
<table class="table">
    <thead>
        <tr>
            @foreach ($columns as $column)
                <th width="{{ $column->getWidth() }}%">{{ strtoupper($column->getLabel()) }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($rows as $row)
            {!! $row !!}
        @endforeach
    </tbody>
</table>
