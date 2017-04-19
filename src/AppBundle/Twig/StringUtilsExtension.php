<?php

namespace AppBundle\Twig;

class StringUtilsExtension extends \Twig_Extension
{
    /** {@inheritDoc} */
    public function getName()
    {
        return 'string_utils';
    }

    /** {@inheritDoc} */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('cut', [$this, 'cut']),
            new \Twig_SimpleFilter('humanize_language', [$this, 'humanizeLanguage']),
        ];
    }

    /**
     * @param string $string
     * @param int $length
     * @return string
     */
    public static function cut($string, $length = 40)
    {
        return (mb_strlen($string) > $length)
            ? mb_substr($string, 0, $length - 4) . " ..."
            : $string
        ;
    }

    /**
     * @param string $languageCode
     * @return string
     */
    public static function humanizeLanguage($languageCode)
    {
        switch ($languageCode) {
            case "ru":
                return "Русский";
            case "uk":
                return "Українська";
            case "en":
                return "English";
            case "de":
                return "Deutsch";
            case "ro":
                return "Română";
            default:
                throw new \InvalidArgumentException(sprintf('Cannot humanize language code "%s"', $languageCode));
        }
    }
}
