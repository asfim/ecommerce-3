<?php
$html = file_get_contents('c:\Users\Admin\Downloads\fashion (1).html');
file_put_contents('temp_html.txt', $html);
echo 'HTML Copied';
