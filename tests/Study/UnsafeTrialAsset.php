<?php


namespace Study;


class UnsafeTrialAsset
{
    function __get($name)
    {
        return 'magic attribute:get';
    }

    function __set($name, $value)
    {
        return 'magic attribute:set';
    }


    public function behavior()
    {
        return 'bar';
    }
}