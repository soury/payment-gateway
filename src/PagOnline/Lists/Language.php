<?php

namespace PagamentiOnline\PagOnline\Lists;

class Language implements LanguageList
{
    const LANGUAGE_ITA = 'IT';
    const LANGUAGE_ENG = 'EN';

    /**
     * @return array
     */
    public function getList()
    {
        return [
            self::LANGUAGE_ITA => 'Italian',
            self::LANGUAGE_ENG => 'English',
        ];
    }
}
