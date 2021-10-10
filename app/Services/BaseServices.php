<?php

namespace App\Services;

class BaseServices
{
    protected function dataTable_draw($draw, $recordsTotal, $recordsFiltered, $data)
    {
        return array(
            'draw'            => $draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data
        );
    }

   
}
