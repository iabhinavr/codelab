<?php

function esc_str($str) {
    $esc_str = htmlentities($str, ENT_QUOTES, "UTF-8");
    return $esc_str;
}