@if(!empty($headers))
    @foreach($headers as $header)

        <div class="o-table__header">
            @if(!empty($header))

                <?php
                    $label = ucwords(str_replace('_',' ',$header));
                    $urlData = request()->input();
                    $urlData = array_merge($urlData, [
                        'order' => $header,
                        'dir' => 'asc',
                    ]);
                    $sortIcon = 'fa-sort';
                    if(request('order') == $header) {

                        if(request('dir', 'asc') == 'asc') {
                            $sortIcon = 'fa-caret-down';
                            $urlData['dir'] = 'desc';
                        } else {
                            $sortIcon = 'fa-caret-up';
                        }
                    }
                    $urlQuery = http_build_query($urlData);
                    $sortUrl = sprintf('?%s', $urlQuery);
                ?>

                <a href="{{ $sortUrl }}">
                    {{ $label }}
                    <i class="fa {{ $sortIcon }}" aria-hidden="true"></i>
                </a>

            @endif
        </div>

    @endforeach
@endif
