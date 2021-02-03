<?php

namespace Domain;

class Lang
{

    const LIST = [
        'en' => 'English',
        'fr' => 'French',
        'ch' => 'Chinese',
        'ar' => 'Arabic'
    ];

    public static function getISOList()
    {
        return array_keys(self::LIST);
    }
}
