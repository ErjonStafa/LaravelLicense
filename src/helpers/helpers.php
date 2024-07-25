<?php

if(! function_exists('get_os')){
    /**
     * Return linux or windows
     *
     * @return string
     */
    function get_os()
    {
        $os = php_uname();

        if (str_contains($os, 'Linux')){
            return 'Linux';
        }

        return 'Windows';
    }
}


if(! function_exists('ascii2hex')) {
    function ascii2hex($ascii) {
        $hex = '';
        for ($i = 0; $i < strlen($ascii); $i++) {
            $byte = strtoupper(dechex(ord($ascii[$i])));
            $byte = str_repeat('0', 2 - strlen($byte)).$byte;
            $hex.=$byte;
        }
        return $hex;
    }
}

if(! function_exists('hex2str')) {
    function hex2str(string $hex): string
    {
        $str = '';
        for($i=0;$i<strlen($hex);$i+=2){
            $str .= chr(hexdec(substr($hex,$i,2)));
        }
        return $str;
    }
}
