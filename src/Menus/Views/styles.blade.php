<style>

    #navtree {
        margin: 0 0 20px 0;
        border-top: 1px dotted #000;
    }

    #navtree-form {
        display: none;
    }

    #navtree-form .o-form__title {
        border-bottom: 1px dotted #000;
    }

    #navtree-output {
        display: none;
        font-family: monospace;
        margin: 20px 0;
        min-height: 400px;
        height: auto;
    }

    #navtree-add-child,
    #navtree-remove {
        display: none;
    }

    .c-menus-form{
        margin-top: 60px;
        /*display: flex;*/
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 350px);
        grid-gap: 15px;
    }

    .c-menus-form > * {

        /*width: calc(50% - 15px);*/
    }

    .c-menus-form > *:first-child {
        /*margin-right: 30px;*/
    }

</style>
