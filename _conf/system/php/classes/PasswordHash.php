<?php

class PasswordHash{

    //Errorliste für das Handling
    public static $errors = [
        "1" => "unerlaubtes Zeichen"
    ];

    //alle replacements für das Translaten
    private static $replaces = [

        //lowercase
        "a" => "37M3GKreWX",
        "b" => "BrMkXMPj0L",
        "c" => "VgvX8KsRjS",
        "d" => "5VUDlZWxRD",
        "e" => "UkT6ulNZ3L",
        "f" => "oukOfG8xsa",
        "g" => "OVrd0hSgk6",
        "h" => "PyApFrLsNj",
        "i" => "aTaaWiXoLE",
        "j" => "OKJSBpASQo",
        "k" => "MfKjeboWjK",
        "l" => "vYdKhXODsE",
        "m" => "S3QOKKwKSG",
        "n" => "cA2zkmdfab",
        "o" => "k3Qlycg3E2",
        "p" => "OUGTM59emJ",
        "q" => "bsP9Mw2D6j",
        "r" => "aD4urKFSYS",
        "s" => "5kP3Sz6HqK",
        "t" => "qmpaRwj7HI",
        "u" => "OMCYUCXGy5",
        "v" => "rG7DagCaSa",
        "w" => "UxUCHDWzqS",
        "x" => "HhA5efC2vW",
        "y" => "KHBqym3nC2",
        "z" => "OdTddtW2FV",
        "ü" => "Dkc00lU0Zy",
        "ä" => "2BGYHTfNpG",
        "ö" => "HVr5T0KbQI",

        //uppercase
        "A" => "EmnjMCTG6l",
        "B" => "Gbu6OR01Yl",
        "C" => "xjZFH5Bd22",
        "D" => "8MvLpeXPTv",
        "E" => "M0mMVAvAa8",
        "F" => "wUDRCOes1Q",
        "G" => "CJ979GL8Bn",
        "H" => "WoIF63tErx",
        "I" => "a5ua2tUEPL",
        "J" => "kzaPDTCEII",
        "K" => "MVieeH2vAZ",
        "L" => "HAGWUv60be",
        "M" => "0c2KpfTXv5",
        "N" => "Ai7ylBJvYE",
        "O" => "rdjYp6hwuF",
        "P" => "C8vVl8obk9",
        "Q" => "WkRB4TDMbk",
        "R" => "IJc14uSgT9",
        "S" => "rPu6RiuT3X",
        "T" => "WcSHORh2Q2",
        "U" => "m55LL2X442",
        "V" => "KW7RphDNJl",
        "W" => "lLGvC0IkWB",
        "X" => "OAItbfTNpe",
        "Y" => "VZvuOzq1Zi",
        "Z" => "XQSz1jZoNY",
        "Ü" => "o6mEsXPSp7",
        "Ä" => "VQxBdDEu1K",
        "Ö" => "8U2nLYQOCt",

        //Zahlen

        "1" => "ZRJYrLy4Yp",
        "2" => "4hz1YBeOx6",
        "3" => "3kCj1fghQs",
        "4" => "7UzxlaRp76",
        "5" => "iVmAhKFyFo",
        "6" => "ATstH3FO2I",
        "7" => "11o4pVd6Up",
        "8" => "AR8VyaotFo",
        "9" => "CbkBBcZfmt",
        "0" => "hiuZMVMdCK",

        //Sonderzeichen

        "_" => "tE4vGJSEjs",
        ":" => "V1cZYP1koh",
        "." => "hGlIsnCD8y",
        "-" => "AQOkWuxX40",
        "?" => "Fk55nJcDwO",
        "=" => "EIKgHvIXBA",
        "}" => "GA9xko7n6H",
        ")" => "GcycZMTDXU",
        "]" => "GKI925q62Z",
        "(" => "a9JkCC4uBK",
        "[" => "edauXZwuWz",
        "/" => "8rZrAdDktq",
        "{" => "O0fMzN2J1x",
        "&" => "8u5Y4gK6te",
        "%" => "D4CDvfLbYK",
        "$" => "d9sqH7SzF6",
        "§" => "XnSmemERIU",
        "!" => "C5fBLtrJ8l",
        "^" => "MSoVRXzZk0",
        "°" => "XDvk2vU1S9",
        "<" => "omVUrSHWqc",
        ">" => "dO25OWktvu",
        "|" => "Lz1wbqDFmx",
        "," => "4gNb4HmTtH",
        "#" => "HMX5f5C8tX",
        "+" => "gTwu5wsso5",
        "*" => "CfE2U8Wajl",
        "~" => "Ca9QCybDS8",
        "'" => "KVOfRW7Aea",
        "ß" => "as4ebu82vQ",
        "@" => "SA09uncXDx",
        "€" => "ZWs8iiNq92"

    ];

    //HashFunction
    static function hashPassword($pw){

        $spw = str_split($pw, 1);
        $hash = uniqid()."_";

        $allowed = array_keys(self::$replaces);

        foreach ($spw as $char){

            if(in_array($char, $allowed)){

                $hash.=self::$replaces[$char];

            }else{
                return "1";
            }

        }
        return $hash."_".uniqid();

    }

    //Checkfunction
    static function checkPassword($pw, User $user){

        $userPW = $user->getUserPassword();

        $userPWSplit = explode("_", $userPW);

        $pwHash = $userPWSplit[1];

        $pwhashes = str_split($pwHash, 10);

        $givenPW = "";

        $hashKeys = array_keys(self::$replaces);

        foreach ($pwhashes as $hash){
            $i = 0;
            foreach (self::$replaces as $replacement){
                if($hash === $replacement){
                    $givenPW.=$hashKeys[$i];
                }
                $i+=1;
            }

        }
        return ($givenPW === $pw);

    }

}