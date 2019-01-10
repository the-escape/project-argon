@if($items->lastPage() > 1)

    <?php
    $pagination = easyPagination(range(1, $items->total()), $items->perPage(), $items->currentPage());
    $presenter = paginationPresenter($pagination, '...', 1, 2, function($element, $hellip, $current_page_number)
    {
        if ($element != $hellip)
        {
            return '<a class="c-pagination__item '.(($element == $current_page_number) ? "active" : "").'" href="'.getUrlWithQueryString(['page'=>$element]).'">'.$element.'</a>';
        }
        return '<span class="c-pagination__spacer">'.$element.'</span>';
    });
    ?>

    <div class="c-pagination">
        <div class="c-pagination__container">
            @if($pagination['page_prev'])
                <a class="c-pagination__link" href="{{ getUrlWithQueryString(['page'=>$pagination['page_prev']])  }}" tabindex="-1">Previous</a>
            @endif

            @foreach ($presenter as $li)
                {!! $li !!}
            @endforeach

            @if($pagination['page_next'])
                <a class="c-pagination__link" href=" {{ getUrlWithQueryString(['page'=>$pagination['page_next']])  }}">Next</a>
            @endif
        </div>
    </div>

@endif