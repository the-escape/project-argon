<?php
/*
 *
 * Unified way of presenting errors regardless if the value passes was a string, array or validator object.
 *
 * */
?>
@if (count($errors) > 0)

    <div class="alert alert-danger">

        <p><strong>Submission failed</strong></p>

        <?php
            if (is_string($errors))
            {
                $errors = [$errors];
            }
            elseif (is_object($errors))
            {
                $errors = $errors->all();
            }
        ?>

        <ul>
            @foreach ($errors as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

    </div>

@endif