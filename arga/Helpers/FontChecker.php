<?php
/**
 * Created by PhpStorm.
 * User: naingminkhant
 * Date: 12/13/18
 * Time: 11:01 AM
 */

namespace Arga\Helpers;

class FontChecker
{
    const UNICODE = 'unicode';
    const ZAWGYI = 'zawgyi';

    public static function check($text)
    {
        return self::zgOrUnicode($text);
    }

    public static function isUnicode($text)
    {
        $check = self::zgOrUnicode($text);
        if ($check === self::UNICODE) {
            return true;
        }

        return false;
    }

    public static function isZawgyi($text)
    {
        $check = self::zgOrUnicode($text);
        if ($check === self::ZAWGYI) {
            return true;
        }

        return false;
    }

    protected static function zgOrUnicode($text)
    {
        $zgPattern = '/ေျ|^ေ|^ျ|[ဢ-ူဲ-္ျ-ွ၀-၏]ျ|္$|ွြ|ျြ|[က-အ]္[ယရဝဟဢ-ဪေ့-္ျ၀-၏]|ီ[ိှဲ]|ဲ[ိီ]|[႐-႙][ါ-ူဲ့ြ-ှ]|[က-ဪ]်[ာ-ီဲ-ံ]|[ဣ-ူဲ-္၀-၏]ေ|[ၾ-ႄ][ခဃစ-ဏဒ-နဖ-ဘဟ]|ဥ္|[ႁႃ]ႏ|ႏ[ၠ-ႍ]|[ိ-ူဲံ့]္|ာ္|ရြ|[^၀-၉]၀ိ|ေ?၀[ါၚီ-ူဲံ-း]|ေ?၇[ာ-ူဲံ-း]|[ုူဲ]႔|္[ၾ-ႄ]/u';

        $uniPattern = '/[ဃငဆဇဈဉညဋဌဍဎဏဒဓနဘရဝဟဠအ]်|ျ[က-အ]ါ|ျ[ါ-း]|\x{103e}|\x{103f}|\x{1031}[^\x{1000}-\x{1021}\x{103b}\x{1040}\x{106a}\x{106b}\x{107e}-\x{1084}\x{108f}\x{1090}]|\x{1031}$|\x{1031}[က-အ]\x{1032}|\x{1025}\x{102f}|\x{103c}\x{103d}[\x{1000}-\x{1001}]|ည်း|ျင်း|င်|န်း|ျာ|င့်/u';

        if (preg_match($uniPattern, $text)) {
            return self::UNICODE;
        }
        if (preg_match($zgPattern, $text)) {
            return self::ZAWGYI;
        }

        return "Not Myanmar";
    }

}
