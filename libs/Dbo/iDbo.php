<?php

namespace libs\Dbo;

interface iDbo {
    public function query($query);
    public function save($model);
}