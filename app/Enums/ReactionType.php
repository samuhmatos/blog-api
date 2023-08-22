<?php

namespace App\Enums;

Enum ReactionType: string{
    case LIKE = "LIKE";
    case UNLIKE = "UNLIKE";

    public static function rand():self
    {
        return rand(0,1) === 1 ? self::LIKE : self::UNLIKE;
    }

}
?>
