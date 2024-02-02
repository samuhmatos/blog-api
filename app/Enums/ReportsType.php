<?php

namespace App\Enums;

enum ReportsType: string {
   case OPEN = "OPEN";

   case REJECTED = "REJECTED";

   case APPROVED = "APPROVED";

   public static function random(): self{
        $cases =  self::cases();

        return $cases[rand(0, count($cases) - 1)];
   }
}
