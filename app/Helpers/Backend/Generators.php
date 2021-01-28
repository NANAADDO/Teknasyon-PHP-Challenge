<?php

namespace App\Helpers\Backend;


use Webpatser\Uuid\Uuid;

class  Generators
{




    public static function Uid()
    {
       return  Uuid::generate();

    }
    public static function UidVersion3()
    {
        return Uuid::generate(3, 'test', Uuid::NS_DNS);

    }

}
