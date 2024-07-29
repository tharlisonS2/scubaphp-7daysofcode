<?php

function render_view($template, $messages = [])
{
    $view = load_content($template, $messages);
    echo $view;
}
function load_content($template, $messages)
{

}