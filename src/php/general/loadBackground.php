<?php

function loadBackground($page)
{
    $bgColor = ''; // Default empty for no background color
    $bgImage = ''; // Default empty for no background image

    switch ($page) {
        case 'home':
            $bgImage = 'Home-Background.jpg';
            break;
        case 'menu':
            break;
        case 'about':
            $bgColor = '#222831'; 
            $bgImage = ''; 
            break;
        default:
            break;
    }

    $background = '';

    if ($bgColor) {
        $background .= 'background-color: ' . $bgColor . ';';
    }

    if ($bgImage) {
        if ($background) {
            $background .= '';
        }
        $background .= 'background-image: url("../../../src/assets/images/' . $bgImage . '");';
        $background .= 'background-size: cover;';
    }

    return $background;
}
?>
