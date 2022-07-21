<?php

namespace App\Models;


class PanelProduct extends Product
{

    public static function booted()
    {
        //static::addGlobalScope();
    }

    public function getForeignKey()
    {
        $parent = get_parent_class($this);

        return (new $parent)->getForeignKey();
    }

    public function getMorphClass()
    {
        $parent = get_parent_class($this);

        return (new $parent)->getMorphClass();
    }
}
