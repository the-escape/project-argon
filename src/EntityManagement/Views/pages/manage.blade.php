@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1>Pages</h1>

        <div class="o-tree js-tree" data-types="{{ $typesJson }}">
            <div class="o-tree__header l-full">
                <div class="o-tree__search o-form">
                    <label for="search">Search</label>
                    <div class="o-form-icon">
                        <input type="tel" id="search" class="js-tree-search" name="search">
                        <div class="o-form-icon__icon">
                            <svg>
                                <use xlink:href="/argon/images/svgicons.svg#search"></use>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="l-full">
                <div class="o-tree__container">
                    <div class="js-tree-container">

                        <ul>
                            @each('argon::pages.tree.item', $entities, 'entity')
                        </ul>


                    </div>
                </div>
            </div>
            <div class="o-form__help-text l-full">
                <p>Right click on each page to see an options menu.</p>
            </div>
        </div>

    </div>
@stop

@section('styles')
@stop
