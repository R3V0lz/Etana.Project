<?php
$Path = './doc/stuffs/sample.docx';
if (file_exists($Path)) {
    if (unlink($Path)) {
        echo "success";
    } else {
        echo "fail";
    }
} else {
    echo "file does not exist";
}