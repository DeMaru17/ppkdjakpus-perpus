<?php

function getStatus($status)
{
    switch ($status) {
        case '1':
            $label = '<span class="badge text-bg-primary p-2">Sedang Dipinjam</span>';
            break;
        case '2':
            $label = '<span class="badge text-bg-success p-2">Sudah Dikembalikan</span>';
            break;


        default:
            $label = "";
            break;
    }
    return $label;
}
