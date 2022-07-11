<?php

namespace Atabasch\Core\Routing;

class RoutePlaceholders{

    private array $placeholders = [
        '/\{([a-zA-Z_]+):single\}/i'    =>  '?(\d)',
        '/\{([a-zA-Z_]+):bool\}/i'      =>  '?(0|1)',
        '/\{([a-zA-Z_]+):boolean\}/i'   =>  '?(0|1)',
        '/\{([a-zA-Z_]+):id\}/i'        =>  '?(-?\d+)',
        '/\{([a-zA-Z_]+):int\}/i'       =>  '?(-?\d+)',
        '/\{([a-zA-Z_]+):number\}/i'    =>  '?(-?[0-9\.]+)',
        '/\{([a-zA-Z_]+):float\}/i'     =>  '?(-?[0-9\.]+)',
        '/\{([a-zA-Z_]+):double\}/i'    =>  '?(-?[0-9\.]+)',
        '/\{([a-zA-Z_]+):slug\}/i'      =>  '?([A-Za-z0-9-_]+)',
        '/\{([a-zA-Z_]+):string\}/i'    =>  '?([A-Za-z0-9-_]+)',
        '/\{([a-zA-Z_]+)\}/i'          =>  '?([A-Za-z0-9-_]+)',
        '/\{([a-zA-Z_]+):alphabet\}/i'  =>  '?([A-Za-z-_]+)',
        '/\{([a-zA-Z_]+):abc\}/i'       =>  '?([A-Za-z-_]+)',
    ];

    public function getRegexPath(string $path=null): string{
        return preg_replace(array_keys(self::$placeholders), array_values(self::$placeholders), $path);
    }

}