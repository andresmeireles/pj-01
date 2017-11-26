<?php

return array(
    "settings" => array(
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,

        'renderer' => array(
            'template_path' => __DIR__."/../resources/",

            // twig only
            'filters' => array(
                'slug' => $slugFilter = new Twig_Filter('slug', function ($string) {
                    $a = array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','Ð','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','?','?','J','j','K','k','L','l','L','l','L','l','?','?','L','l','N','n','N','n','N','n','?','O','o','O','o','O','o','Œ','œ','R','r','R','r','R','r','S','s','S','s','S','s','Š','š','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Ÿ','Z','z','Z','z','Ž','ž','?','ƒ','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','?','?','?','?','?','?');
                    $b = array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','A','a','AE','ae','O','o');
                    return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/','/[ -]+/','/^-|-$/'), array('','-',''), str_replace($a, $b, $string)));
                }),
                'height' => $heightFilter = new Twig_Filter('height', function ($string) {
                    return str_pad($string, 4, '0', STR_PAD_RIGHT);
                }),
                'money' => $moneyFilter = new Twig_Filter('money', function ($string) {
                    return number_format($string, 2, ',', '.');
                })
            ),
        ),

        'monolog' => array(
            'path' => __DIR__.'/../logs/appLogs',
        ),

        'doctrine' => array(
            'entity_path' => __DIR__.'/Entity/',
            'dbparams' => array(
                'host'      => mysql,
                'driver'    => getenv(DATA_BASE_DRIVE),
                'dbname'    => getenv(DATA_BASE_NAME),
                'user'      => getenv(DATA_BASE_USER),
                'password'  => getenv(DATA_BASE_PASS),
                'charset' => 'UTF8',
            )
        ),
        
        'reports' => array(
            'font_path' => __DIR__.'/../reports/fonts',
        ),
    ),
);
