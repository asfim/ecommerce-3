<?php
$html = file_get_contents('c:\Users\Admin\Downloads\fashion (1).html');
preg_match('/<style>(.*?)<\/style>/s', $html, $matches);
if (isset($matches[1])) {
    file_put_contents('public/css/rongdhonu.css', trim($matches[1]));
    echo 'CSS Extracted';
} else {
    echo 'No style found';
}
