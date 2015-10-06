<?php

/*
 *
 * Unified way of presenting messages regardless if the value passes was a string, array or validator object.
 *
 * */


    if (session('message'))
    {
        $message = session('message');
    }

?>

@if (isset($message) && count($message) > 0)

    <div class="alert alert-success">

        <?php
        if (is_string($message))
        {
            $message = [$message];
        }
        elseif (is_object($message))
        {
            $message = $message->all();
        }
        ?>

        <ul>
            @foreach ($message as $msg)
                <li>{{ $msg }}</li>
            @endforeach
        </ul>

    </div>

@endif

@if (isset($errors) && count($errors) > 0)

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