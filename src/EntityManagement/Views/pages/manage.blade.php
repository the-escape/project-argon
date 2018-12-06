@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <header class="c-header c-container">
        <div class="c-header__title">
            <h1>Pages</h1>
        </div>
    </header>

    <main class="c-container c-container--main">

        <div class="o-tree js-tree" data-types="{{ $typesJson }}">
            <div class="o-tree__header">
                <div class="o-tree__search o-form">
                    <div class="o-form-icon">
                        <input type="text" id="search" class="js-tree-search" name="search" placeholder="Search pages..." autocomplete="off">
                        <div class="o-form-icon__icon">
                            <svg>
                                <use xlink:href="/argon/images/svgicons.svg#search"></use>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="o-tree__container">
                <div class="js-tree-container">

                    <ul>
                        @each('argon::pages.tree.item', $entities, 'entity')
                    </ul>


                </div>
            </div>
        </div>

    </main>

    <footer class="c-footer__wrapper">
        <div class="c-footer c-container c-footer--fixed">
            <div class="c-footer__container">

                <div class="o-form__help-text l-halves">
                    <div>
                        <p>Right click on each page to see an options menu.</p>
                    </div>
                    <div>
                        <p class="h-text--right">Alt click on each page to open edit in new tab.</p>
                    </div>
                </div>

            </div>
        </div>
    </footer>

@stop

@section('styles')
@stop
