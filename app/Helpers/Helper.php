<?php

namespace App\Helpers;

use App\Models\Role;
use App\Models\TestLetter;
use App\Models\User;
use Illuminate\Support\Carbon;

class Helper
{

    public static function title_sut_srut_form($form_step)
    {
        switch ($form_step) {
            case 1:
                $form_step_name = 'General';
                break;
            case 2:
                $form_step_name = 'Identitas Kendaraan';
                break;
            case 3:
                $form_step_name = 'Nomor dan Tempat Penomoran Landasan/Chassis, Engine, dan Motor Kendaraan Uji';
                break;
            case 4:
                $form_step_name = 'Motor Penggerak';
                break;
            case 5:
                $form_step_name = 'Sistem Bahan Bakar';
                break;
            case 6:
                $form_step_name = 'Dimensi Kendaraan';
                break;
            case 7:
                $form_step_name = 'Ukuran Ban dan Lingkar Roda';
                break;
            case 8:
                $form_step_name = 'Berat Kendaraan';
                break;
            case 9:
                $form_step_name = 'Penerus Daya (Tranmisi / Kopling)';
                break;
            case 10:
                $form_step_name = 'Sistem Pengereman';
                break;
            case 11:
                $form_step_name = 'Sistem Suspensi';
                break;
            case 11:
                $form_step_name = 'Sistem Kemudi';
                break;
            case 12:
                $form_step_name = 'Lain-Lain';
                break;
            default:
                $form_step_name = 'Lain-Lain';
        }

        return $form_step_name;
    }

    public static function generateTestLetterCode()
    {
        $date = Carbon::now()->format('Ymd');
        $prefix = 'TL-' . $date;

        // Hitung jumlah test letter di tanggal ini
        $count = TestLetter::whereDate('created_at', Carbon::today())->count() + 1;
        $number = str_pad($count, 3, '0', STR_PAD_LEFT);

        return $prefix . '-' . $number;
    }

    public static function check_step_form_title($step)
    {
        switch ($step) {
            case 1:
                return 'Penanggung Jawab dan Bengkel';
            case 2:
                return 'Dokumen';
            case 3:
                return 'Tenaga Ahli';
            case 4:
                return 'Peralatan';
        }
    }
    public static function check_status_conversion($status)
    {

        switch ($status) {
            case 'checking':
                return 'Periksa Data Upload';
            case 'verified_upload':
                return 'Data Upload Terverifikasi';
            case 'verified_zoom':
                return 'Verifikasi Zoom Terverifikasi';
            case 'verified_field':
                return 'Verifikasi Lapangan Terverifikasi';
            case 'finished':
                return 'Di Terima';
            case 'is_being_uploaded':
                return 'Data Sedang Di Upload';
            default:
                return 'Di Tolak';
        }
    }

    public static function encrypt($data)
    {
        $passphrase = '__@#MinorSangSuratma88Anantaka99';
        $cipher = "AES-256-CBC";
        $secreet_iv = 'Batulablab12@#MinorHasTag$&=KlTy!';
        $key = hash('sha256', $passphrase);
        $iv = substr(hash('sha256',$secreet_iv), 0, 16);
        $options = 0;

        $ciphertext = openssl_encrypt($data, $cipher, $key, $options, $iv);

        return base64_encode($ciphertext);
    }

    public static function decrypt($data)
    {
        $passphrase = '__@#MinorSangSuratma88Anantaka99';
        $cipher = "AES-256-CBC";
        $secreet_iv = 'Batulablab12@#MinorHasTag$&=KlTy!';
        $key = hash('sha256', $passphrase);
        $iv = substr(hash('sha256',$secreet_iv), 0, 16);
        $options = 0;

        $decode = openssl_decrypt(base64_decode($data), $cipher, $key, $options, $iv);

        return $decode ? $decode : null;
    }

    public static function strPregReplace($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    /**
     * @param $value
     * @param $currency
     * @param $decimal
     * @return string
     */
    public static function convertCurrency($value, $currency = 'idr', $decimal = 0)
    {
        switch ($currency) {
            case 'idr':
                $cur = number_format($value, $decimal, ",", ".");
                $cur = 'Rp ' . $cur;
                break;
            default:
                $cur = number_format($value, $decimal, ",", ".");
        }
        return $cur;
    }


    /**
     * 1.000 => 1000
     *
     * @param  mixed $value
     * @param  mixed $currency
     * @return string|int|float
     */
    public static function reverseCurrency($value, $currency = 'idr')
    {
        switch ($currency) {
            case 'idr':
                $cur = implode("", explode(".", $value));
                $cur = implode(".", explode(",", $cur));
                $cur = substr($cur, 2);
                $cur = (int) $cur;
                break;
            default:
                $cur = implode("", explode(".", $value));
                $cur = implode(".", explode(",", $cur));
        }
        return $cur;
    }

    public static function languageList() : object
    {
        return json_decode(json_encode([
            "ab" => [
                "name" => "Abkhaz",
                "nativeName" => "аҧсуа"
            ],
            "aa" => [
                "name" => "Afar",
                "nativeName" => "Afaraf"
            ],
            "af" => [
                "name" => "Afrikaans",
                "nativeName" => "Afrikaans"
            ],
            "ak" => [
                "name" => "Akan",
                "nativeName" => "Akan"
            ],
            "sq" => [
                "name" => "Albanian",
                "nativeName" => "Shqip"
            ],
            "am" => [
                "name" => "Amharic",
                "nativeName" => "አማርኛ"
            ],
            "ar" => [
                "name" => "Arabic",
                "nativeName" => "العربية"
            ],
            "an" => [
                "name" => "Aragonese",
                "nativeName" => "Aragonés"
            ],
            "hy" => [
                "name" => "Armenian",
                "nativeName" => "Հայերեն"
            ],
            "as" => [
                "name" => "Assamese",
                "nativeName" => "অসমীয়া"
            ],
            "av" => [
                "name" => "Avaric",
                "nativeName" => "авар мацӀ, магӀарул мацӀ"
            ],
            "ae" => [
                "name" => "Avestan",
                "nativeName" => "avesta"
            ],
            "ay" => [
                "name" => "Aymara",
                "nativeName" => "aymar aru"
            ],
            "az" => [
                "name" => "Azerbaijani",
                "nativeName" => "azərbaycan dili"
            ],
            "bm" => [
                "name" => "Bambara",
                "nativeName" => "bamanankan"
            ],
            "ba" => [
                "name" => "Bashkir",
                "nativeName" => "башҡорт теле"
            ],
            "eu" => [
                "name" => "Basque",
                "nativeName" => "euskara, euskera"
            ],
            "be" => [
                "name" => "Belarusian",
                "nativeName" => "Беларуская"
            ],
            "bn" => [
                "name" => "Bengali",
                "nativeName" => "বাংলা"
            ],
            "bh" => [
                "name" => "Bihari",
                "nativeName" => "भोजपुरी"
            ],
            "bi" => [
                "name" => "Bislama",
                "nativeName" => "Bislama"
            ],
            "bs" => [
                "name" => "Bosnian",
                "nativeName" => "bosanski jezik"
            ],
            "br" => [
                "name" => "Breton",
                "nativeName" => "brezhoneg"
            ],
            "bg" => [
                "name" => "Bulgarian",
                "nativeName" => "български език"
            ],
            "my" => [
                "name" => "Burmese",
                "nativeName" => "ဗမာစာ"
            ],
            "ca" => [
                "name" => "Catalan; Valencian",
                "nativeName" => "Català"
            ],
            "ch" => [
                "name" => "Chamorro",
                "nativeName" => "Chamoru"
            ],
            "ce" => [
                "name" => "Chechen",
                "nativeName" => "нохчийн мотт"
            ],
            "ny" => [
                "name" => "Chichewa; Chewa; Nyanja",
                "nativeName" => "chiCheŵa, chinyanja"
            ],
            "zh" => [
                "name" => "Chinese",
                "nativeName" => "中文 (Zhōngwén), 汉语, 漢語"
            ],
            "cv" => [
                "name" => "Chuvash",
                "nativeName" => "чӑваш чӗлхи"
            ],
            "kw" => [
                "name" => "Cornish",
                "nativeName" => "Kernewek"
            ],
            "co" => [
                "name" => "Corsican",
                "nativeName" => "corsu, lingua corsa"
            ],
            "cr" => [
                "name" => "Cree",
                "nativeName" => "ᓀᐦᐃᔭᐍᐏᐣ"
            ],
            "hr" => [
                "name" => "Croatian",
                "nativeName" => "hrvatski"
            ],
            "cs" => [
                "name" => "Czech",
                "nativeName" => "česky, čeština"
            ],
            "da" => [
                "name" => "Danish",
                "nativeName" => "dansk"
            ],
            "dv" => [
                "name" => "Divehi; Dhivehi; Maldivian;",
                "nativeName" => "ދިވެހި"
            ],
            "nl" => [
                "name" => "Dutch",
                "nativeName" => "Nederlands, Vlaams"
            ],
            "en" => [
                "name" => "English",
                "nativeName" => "English"
            ],
            "eo" => [
                "name" => "Esperanto",
                "nativeName" => "Esperanto"
            ],
            "et" => [
                "name" => "Estonian",
                "nativeName" => "eesti, eesti keel"
            ],
            "ee" => [
                "name" => "Ewe",
                "nativeName" => "Eʋegbe"
            ],
            "fo" => [
                "name" => "Faroese",
                "nativeName" => "føroyskt"
            ],
            "fj" => [
                "name" => "Fijian",
                "nativeName" => "vosa Vakaviti"
            ],
            "fi" => [
                "name" => "Finnish",
                "nativeName" => "suomi, suomen kieli"
            ],
            "fr" => [
                "name" => "French",
                "nativeName" => "français, langue française"
            ],
            "ff" => [
                "name" => "Fula; Fulah; Pulaar; Pular",
                "nativeName" => "Fulfulde, Pulaar, Pular"
            ],
            "gl" => [
                "name" => "Galician",
                "nativeName" => "Galego"
            ],
            "ka" => [
                "name" => "Georgian",
                "nativeName" => "ქართული"
            ],
            "de" => [
                "name" => "German",
                "nativeName" => "Deutsch"
            ],
            "el" => [
                "name" => "Greek, Modern",
                "nativeName" => "Ελληνικά"
            ],
            "gn" => [
                "name" => "Guaraní",
                "nativeName" => "Avañeẽ"
            ],
            "gu" => [
                "name" => "Gujarati",
                "nativeName" => "ગુજરાતી"
            ],
            "ht" => [
                "name" => "Haitian; Haitian Creole",
                "nativeName" => "Kreyòl ayisyen"
            ],
            "ha" => [
                "name" => "Hausa",
                "nativeName" => "Hausa, هَوُسَ"
            ],
            "he" => [
                "name" => "Hebrew (modern)",
                "nativeName" => "עברית"
            ],
            "hz" => [
                "name" => "Herero",
                "nativeName" => "Otjiherero"
            ],
            "hi" => [
                "name" => "Hindi",
                "nativeName" => "हिन्दी, हिंदी"
            ],
            "ho" => [
                "name" => "Hiri Motu",
                "nativeName" => "Hiri Motu"
            ],
            "hu" => [
                "name" => "Hungarian",
                "nativeName" => "Magyar"
            ],
            "ia" => [
                "name" => "Interlingua",
                "nativeName" => "Interlingua"
            ],
            "id" => [
                "name" => "Indonesian",
                "nativeName" => "Bahasa Indonesia"
            ],
            "ie" => [
                "name" => "Interlingue",
                "nativeName" => "Originally called Occidental; then Interlingue after WWII"
            ],
            "ga" => [
                "name" => "Irish",
                "nativeName" => "Gaeilge"
            ],
            "ig" => [
                "name" => "Igbo",
                "nativeName" => "Asụsụ Igbo"
            ],
            "ik" => [
                "name" => "Inupiaq",
                "nativeName" => "Iñupiaq, Iñupiatun"
            ],
            "io" => [
                "name" => "Ido",
                "nativeName" => "Ido"
            ],
            "is" => [
                "name" => "Icelandic",
                "nativeName" => "Íslenska"
            ],
            "it" => [
                "name" => "Italian",
                "nativeName" => "Italiano"
            ],
            "iu" => [
                "name" => "Inuktitut",
                "nativeName" => "ᐃᓄᒃᑎᑐᑦ"
            ],
            "ja" => [
                "name" => "Japanese",
                "nativeName" => "日本語 (にほんご／にっぽんご)"
            ],
            "jv" => [
                "name" => "Javanese",
                "nativeName" => "basa Jawa"
            ],
            "kl" => [
                "name" => "Kalaallisut, Greenlandic",
                "nativeName" => "kalaallisut, kalaallit oqaasii"
            ],
            "kn" => [
                "name" => "Kannada",
                "nativeName" => "ಕನ್ನಡ"
            ],
            "kr" => [
                "name" => "Kanuri",
                "nativeName" => "Kanuri"
            ],
            "ks" => [
                "name" => "Kashmiri",
                "nativeName" => "कश्मीरी, كشميري‎"
            ],
            "kk" => [
                "name" => "Kazakh",
                "nativeName" => "Қазақ тілі"
            ],
            "km" => [
                "name" => "Khmer",
                "nativeName" => "ភាសាខ្មែរ"
            ],
            "ki" => [
                "name" => "Kikuyu, Gikuyu",
                "nativeName" => "Gĩkũyũ"
            ],
            "rw" => [
                "name" => "Kinyarwanda",
                "nativeName" => "Ikinyarwanda"
            ],
            "ky" => [
                "name" => "Kirghiz, Kyrgyz",
                "nativeName" => "кыргыз тили"
            ],
            "kv" => [
                "name" => "Komi",
                "nativeName" => "коми кыв"
            ],
            "kg" => [
                "name" => "Kongo",
                "nativeName" => "KiKongo"
            ],
            "ko" => [
                "name" => "Korean",
                "nativeName" => "한국어 (韓國語), 조선말 (朝鮮語)"
            ],
            "ku" => [
                "name" => "Kurdish",
                "nativeName" => "Kurdî, كوردی‎"
            ],
            "kj" => [
                "name" => "Kwanyama, Kuanyama",
                "nativeName" => "Kuanyama"
            ],
            "la" => [
                "name" => "Latin",
                "nativeName" => "latine, lingua latina"
            ],
            "lb" => [
                "name" => "Luxembourgish, Letzeburgesch",
                "nativeName" => "Lëtzebuergesch"
            ],
            "lg" => [
                "name" => "Luganda",
                "nativeName" => "Luganda"
            ],
            "li" => [
                "name" => "Limburgish, Limburgan, Limburger",
                "nativeName" => "Limburgs"
            ],
            "ln" => [
                "name" => "Lingala",
                "nativeName" => "Lingála"
            ],
            "lo" => [
                "name" => "Lao",
                "nativeName" => "ພາສາລາວ"
            ],
            "lt" => [
                "name" => "Lithuanian",
                "nativeName" => "lietuvių kalba"
            ],
            "lu" => [
                "name" => "Luba-Katanga",
                "nativeName" => ""
            ],
            "lv" => [
                "name" => "Latvian",
                "nativeName" => "latviešu valoda"
            ],
            "gv" => [
                "name" => "Manx",
                "nativeName" => "Gaelg, Gailck"
            ],
            "mk" => [
                "name" => "Macedonian",
                "nativeName" => "македонски јазик"
            ],
            "mg" => [
                "name" => "Malagasy",
                "nativeName" => "Malagasy fiteny"
            ],
            "ms" => [
                "name" => "Malay",
                "nativeName" => "bahasa Melayu, بهاس ملايو‎"
            ],
            "ml" => [
                "name" => "Malayalam",
                "nativeName" => "മലയാളം"
            ],
            "mt" => [
                "name" => "Maltese",
                "nativeName" => "Malti"
            ],
            "mi" => [
                "name" => "Māori",
                "nativeName" => "te reo Māori"
            ],
            "mr" => [
                "name" => "Marathi (Marāṭhī)",
                "nativeName" => "मराठी"
            ],
            "mh" => [
                "name" => "Marshallese",
                "nativeName" => "Kajin M̧ajeļ"
            ],
            "mn" => [
                "name" => "Mongolian",
                "nativeName" => "монгол"
            ],
            "na" => [
                "name" => "Nauru",
                "nativeName" => "Ekakairũ Naoero"
            ],
            "nv" => [
                "name" => "Navajo, Navaho",
                "nativeName" => "Diné bizaad, Dinékʼehǰí"
            ],
            "nb" => [
                "name" => "Norwegian Bokmål",
                "nativeName" => "Norsk bokmål"
            ],
            "nd" => [
                "name" => "North Ndebele",
                "nativeName" => "isiNdebele"
            ],
            "ne" => [
                "name" => "Nepali",
                "nativeName" => "नेपाली"
            ],
            "ng" => [
                "name" => "Ndonga",
                "nativeName" => "Owambo"
            ],
            "nn" => [
                "name" => "Norwegian Nynorsk",
                "nativeName" => "Norsk nynorsk"
            ],
            "no" => [
                "name" => "Norwegian",
                "nativeName" => "Norsk"
            ],
            "ii" => [
                "name" => "Nuosu",
                "nativeName" => "ꆈꌠ꒿ Nuosuhxop"
            ],
            "nr" => [
                "name" => "South Ndebele",
                "nativeName" => "isiNdebele"
            ],
            "oc" => [
                "name" => "Occitan",
                "nativeName" => "Occitan"
            ],
            "oj" => [
                "name" => "Ojibwe, Ojibwa",
                "nativeName" => "ᐊᓂᔑᓈᐯᒧᐎᓐ"
            ],
            "cu" => [
                "name" => "Old Church Slavonic, Church Slavic, Church Slavonic, Old Bulgarian, Old Slavonic",
                "nativeName" => "ѩзыкъ словѣньскъ"
            ],
            "om" => [
                "name" => "Oromo",
                "nativeName" => "Afaan Oromoo"
            ],
            "or" => [
                "name" => "Oriya",
                "nativeName" => "ଓଡ଼ିଆ"
            ],
            "os" => [
                "name" => "Ossetian, Ossetic",
                "nativeName" => "ирон æвзаг"
            ],
            "pa" => [
                "name" => "Panjabi, Punjabi",
                "nativeName" => "ਪੰਜਾਬੀ, پنجابی‎"
            ],
            "pi" => [
                "name" => "Pāli",
                "nativeName" => "पाऴि"
            ],
            "fa" => [
                "name" => "Persian",
                "nativeName" => "فارسی"
            ],
            "pl" => [
                "name" => "Polish",
                "nativeName" => "polski"
            ],
            "ps" => [
                "name" => "Pashto, Pushto",
                "nativeName" => "پښتو"
            ],
            "pt" => [
                "name" => "Portuguese",
                "nativeName" => "Português"
            ],
            "qu" => [
                "name" => "Quechua",
                "nativeName" => "Runa Simi, Kichwa"
            ],
            "rm" => [
                "name" => "Romansh",
                "nativeName" => "rumantsch grischun"
            ],
            "rn" => [
                "name" => "Kirundi",
                "nativeName" => "kiRundi"
            ],
            "ro" => [
                "name" => "Romanian, Moldavian, Moldovan",
                "nativeName" => "română"
            ],
            "ru" => [
                "name" => "Russian",
                "nativeName" => "русский язык"
            ],
            "sa" => [
                "name" => "Sanskrit (Saṁskṛta)",
                "nativeName" => "संस्कृतम्"
            ],
            "sc" => [
                "name" => "Sardinian",
                "nativeName" => "sardu"
            ],
            "sd" => [
                "name" => "Sindhi",
                "nativeName" => "सिन्धी, سنڌي، سندھی‎"
            ],
            "se" => [
                "name" => "Northern Sami",
                "nativeName" => "Davvisámegiella"
            ],
            "sm" => [
                "name" => "Samoan",
                "nativeName" => "gagana faa Samoa"
            ],
            "sg" => [
                "name" => "Sango",
                "nativeName" => "yângâ tî sängö"
            ],
            "sr" => [
                "name" => "Serbian",
                "nativeName" => "српски језик"
            ],
            "gd" => [
                "name" => "Scottish Gaelic; Gaelic",
                "nativeName" => "Gàidhlig"
            ],
            "sn" => [
                "name" => "Shona",
                "nativeName" => "chiShona"
            ],
            "si" => [
                "name" => "Sinhala, Sinhalese",
                "nativeName" => "සිංහල"
            ],
            "sk" => [
                "name" => "Slovak",
                "nativeName" => "slovenčina"
            ],
            "sl" => [
                "name" => "Slovene",
                "nativeName" => "slovenščina"
            ],
            "so" => [
                "name" => "Somali",
                "nativeName" => "Soomaaliga, af Soomaali"
            ],
            "st" => [
                "name" => "Southern Sotho",
                "nativeName" => "Sesotho"
            ],
            "es" => [
                "name" => "Spanish; Castilian",
                "nativeName" => "español, castellano"
            ],
            "su" => [
                "name" => "Sundanese",
                "nativeName" => "Basa Sunda"
            ],
            "sw" => [
                "name" => "Swahili",
                "nativeName" => "Kiswahili"
            ],
            "ss" => [
                "name" => "Swati",
                "nativeName" => "SiSwati"
            ],
            "sv" => [
                "name" => "Swedish",
                "nativeName" => "svenska"
            ],
            "ta" => [
                "name" => "Tamil",
                "nativeName" => "தமிழ்"
            ],
            "te" => [
                "name" => "Telugu",
                "nativeName" => "తెలుగు"
            ],
            "tg" => [
                "name" => "Tajik",
                "nativeName" => "тоҷикӣ, toğikī, تاجیکی‎"
            ],
            "th" => [
                "name" => "Thai",
                "nativeName" => "ไทย"
            ],
            "ti" => [
                "name" => "Tigrinya",
                "nativeName" => "ትግርኛ"
            ],
            "bo" => [
                "name" => "Tibetan Standard, Tibetan, Central",
                "nativeName" => "བོད་ཡིག"
            ],
            "tk" => [
                "name" => "Turkmen",
                "nativeName" => "Türkmen, Түркмен"
            ],
            "tl" => [
                "name" => "Tagalog",
                "nativeName" => "Wikang Tagalog, ᜏᜒᜃᜅ᜔ ᜆᜄᜎᜓᜄ᜔"
            ],
            "tn" => [
                "name" => "Tswana",
                "nativeName" => "Setswana"
            ],
            "to" => [
                "name" => "Tonga (Tonga Islands)",
                "nativeName" => "faka Tonga"
            ],
            "tr" => [
                "name" => "Turkish",
                "nativeName" => "Türkçe"
            ],
            "ts" => [
                "name" => "Tsonga",
                "nativeName" => "Xitsonga"
            ],
            "tt" => [
                "name" => "Tatar",
                "nativeName" => "татарча, tatarça, تاتارچا‎"
            ],
            "tw" => [
                "name" => "Twi",
                "nativeName" => "Twi"
            ],
            "ty" => [
                "name" => "Tahitian",
                "nativeName" => "Reo Tahiti"
            ],
            "ug" => [
                "name" => "Uighur, Uyghur",
                "nativeName" => "Uyƣurqə, ئۇيغۇرچە‎"
            ],
            "uk" => [
                "name" => "Ukrainian",
                "nativeName" => "українська"
            ],
            "ur" => [
                "name" => "Urdu",
                "nativeName" => "اردو"
            ],
            "uz" => [
                "name" => "Uzbek",
                "nativeName" => "zbek, Ўзбек, أۇزبېك‎"
            ],
            "ve" => [
                "name" => "Venda",
                "nativeName" => "Tshivenḓa"
            ],
            "vi" => [
                "name" => "Vietnamese",
                "nativeName" => "Tiếng Việt"
            ],
            "vo" => [
                "name" => "Volapük",
                "nativeName" => "Volapük"
            ],
            "wa" => [
                "name" => "Walloon",
                "nativeName" => "Walon"
            ],
            "cy" => [
                "name" => "Welsh",
                "nativeName" => "Cymraeg"
            ],
            "wo" => [
                "name" => "Wolof",
                "nativeName" => "Wollof"
            ],
            "fy" => [
                "name" => "Western Frisian",
                "nativeName" => "Frysk"
            ],
            "xh" => [
                "name" => "Xhosa",
                "nativeName" => "isiXhosa"
            ],
            "yi" => [
                "name" => "Yiddish",
                "nativeName" => "ייִדיש"
            ],
            "yo" => [
                "name" => "Yoruba",
                "nativeName" => "Yorùbá"
            ],
            "za" => [
                "name" => "Zhuang, Chuang",
                "nativeName" => "Saɯ cueŋƅ, Saw cuengh"
            ]
        ]));
    }

    public static function generate_uuid($length = 13) : string
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length);
    }

}
