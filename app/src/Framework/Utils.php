<?php

namespace Framework;

class Utils
{
    /**
     * Sanitize value
     *
     * @param string $value
     *  The value of the malicious string you want to sanitize
     * @return string
     *  Return the sanitized string
     */
    public function sanitize($value)
    {
        if (!is_null($value)) {
            $data = trim($value);
            $data = htmlspecialchars($data, ENT_QUOTES, "UTF-8");
            $data = strip_tags($data);
            return $data;
        }
    }

    /**
     * Show custom alerts when needed
     *
     * @param string $message
     *  The message you want to show
     * @param string $style
     *  The style of the message using bootstrap colors
     * @param string $icon
     *  The alert icon using font awesome icons
     * @return string
     *  Return a formatted message as an HTML code
     */
    public function alert($message, $style = "primary", $icon = "info-circle")
    {
        if ($icon != null) {
            $icon = sprintf('<span class="fa fa-%s"></span>', $this->sanitize($icon));
        } else {
            $icon = "";
        }

        return sprintf(
            '<div class="alert alert-%s">%s %s</div>',
            $this->sanitize($style),
            $icon,
            $this->sanitize($message)
        );
    }

    /**
     * Show dismissible alerts when needed
     *
     * @param string $message
     *  The message you want to show
     * @param string $style
     *  The style of the message using bootstrap colors
     * @param string $icon
     *  The alert icon using font awesome icons
     * @return string
     *  Return a formatted message as an HTML code
     */
    public function dismissibleAlert($message, $style = "primary", $icon = "info-circle")
    {
        if ($icon != null) {
            $icon = sprintf('<span class="fa fa-%s"></span>', $this->sanitize($icon));
        } else {
            $icon = "";
        }

        return sprintf(
            '<div class="alert alert-%s alert-dismissible fade show">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>%s %s
             </div>',
            $this->sanitize($style),
            $icon,
            $message
        );
    }

    /**
     * Redirect a user to a page when needed
     *
     * @param string $url
     *  The URL or the page you want to redirect the user to it.
     * @return void
     */
    public function redirect($url)
    {
        header('Location: ' . $url, true, 301);
        exit;
    }

    /**
     * Show an input with a custom value when needed, like CRSF value
     *
     * @param string $name
     *  The name of the input example "CSRF"
     * @param string $value
     *  The value of the input example a CSRF token
     * @param bool $hidden
     *  Set true if you want to make the input hidden otherwise false
     * @return string
     *  Return a formatted input as an HTML code
     */
    public function input($name, $value, $hidden = true)
    {
        $h = ($hidden ? 'hidden' : "");

        $name = $this->sanitize($name);

        return sprintf(
            '<input type="text" value="%s" name="%s" id="%s" %s />',
            $this->sanitize($value),
            $name,
            $name,
            $h
        );
    }

    /**
     * Check if a link is active or not in the navbar
     *
     * @param $page
     *  Page variable exists on every page in this project
     * @param string $page_name
     *  The page name you want to check
     * @return string
     *  Return active or null
     */
    public function linkActive($page, $page_name)
    {
        if (isset($page) && $page != null) {
            return ($page == $page_name) ? "active" : "";
        } else {
            return "";
        }
    }

    /**
     * Search for a value inside an associative array
     *
     * @param array $array
     *  The array you want to search inside it
     * @param mixex $key
     *  The kay you want to check is value
     * @param mixed $val
     *  The value you want to find in the array
     * @return bool
     *  Return true if it exists otherwise false
     */
    public function findKeyValue($array, $key, $val)
    {
        foreach ($array as $item) {
            if (is_array($item) && $this->findKeyValue($item, $key, $val)) {
                return true;
            }

            if (isset($item[$key]) && $item[$key] == $val) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check, Validate and Format a URL
     *
     * @param mixed $url
     *  The url you want to check and validate
     * @return mixed
     *  Return a valid url, localhost, or an invalid message
     */
    public function validateURL($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $url_parase = parse_url(filter_var($url, FILTER_SANITIZE_URL));
            return $url_parase['scheme'] . "://" . $url_parase['host'] . "/";
        } elseif (filter_var($url, FILTER_VALIDATE_IP)) {
            return $url;
        } elseif ($url == "localhost") {
            return $url;
        } else {
            return "Domain does not exist";
        }
    }

    /**
     * Check if the provided email address is valid or not
     *
     * @param string $email
     *  The email address you want to check it against the function rules
     * @return bool
     *  Return true if the email address is valid otherwise return false
     */
    public function validateEmail($email)
    {

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        $domain = strtolower(substr($email, strpos($email, '@') + 1));

        // A list of popular email providers
        $providers = [
            'gmail.com',
            'hotmail.com',
            'outlook.com',
            'msn.com',
            'outlook.sa',
            'aol.com',
            'protonmail.com'
        ];

        $inarray = in_array($domain, $providers);

        return (filter_var($email, FILTER_VALIDATE_EMAIL) && checkdnsrr($domain) != false && $inarray);
    }

    /**
     * Return the full website url
     *
     * @return string
     *  Return the full website url
     */
    public function siteUrl($file = null)
    {
        if (defined("SITE_URL") && SITE_URL != null) {
            if ($file != null) {
                return rtrim(SITE_URL, "/") . $file;
            } else {
                return rtrim(SITE_URL, "/");
            }
        }
    }

    /**
     * Create a cookie that expires in 30 days when needed
     *
     * @param string $name
     *  The cookie name
     * @param mixed $value
     *  The cookie value
     * @return bool
     *  Return true if the cookie is created
     */
    public function createCookie($name, $value)
    {
        if (!isset($_COOKIE[$name])) {
            if (setcookie($name, $value, time() + 60 * 60 * 24 * 30, "/")) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Delete a cookie when needed
     *
     * @param string $name
     *  The cookie name
     * @return bool
     *  Return true if the cookie is removed
     */
    public function deleteCookie($name)
    {
        if (isset($_COOKIE[$name])) {
            if (setcookie($name, "", time() - 3600, "/")) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Enqueue a stylesheet file when needed
     *
     * @param string $style_path
     *  The fulll path for the stylesheet file
     * @return bool
     */
    public function style($style_path, $assets = "assets")
    {
        if (filter_var($style_path, FILTER_VALIDATE_URL)) {
            $site_url = $style_path;
        } else {
            $site_url = $this->siteUrl("/{$assets}/{$style_path}");
        }
        echo "<link href=\"{$site_url}\" rel=\"stylesheet\" />" . "\n";
        return true;
    }

    /**
     * Enqueue a javascript file when needed
     *
     * @param string $script_path
     *  The fulll path for the javascript file
     * @return bool
     */
    public function script($script_path, $assets = "assets")
    {
        if (filter_var($script_path, FILTER_VALIDATE_URL)) {
            $site_url = $script_path;
        } else {
            $site_url = $this->siteUrl("/{$assets}/{$script_path}");
        }
        echo "<script src=\"{$site_url}\"></script>" . "\n";
        return true;
    }

    /**
     * Like Codeigniter sanatize a key:value pair array
     *
     * @param array $data
     * @return array
     */
    public function esc($data)
    {
        $sanitized = [];

        foreach ($data as $key => $value) {
            $sanitized[$this->sanitize($key)] = $this->sanitize($value);
        }

        return $sanitized;
    }

    public function getIP()
    {
        return json_decode(file_get_contents("https://api.myip.com"));
    }

    /**
     * Escape SQL Queries
     *
     * @param string $value
     *  The sql query you want to escape
     * @return string
     *  Return the escaped SQL query
     */
    public function escape($value)
    {
        $data = str_replace(
            array("\\", "\0", "\n", "\r", "\x1a", "'", '"'),
            array("\\\\", "\\0", "\\n", "\\r", "\Z", "\'", '\"'),
            $value
        );
        return $data;
    }

    /**
     * Returns an array with the pre-defined countries names and codes
     *
     * @return array
     *  Return an array that contains the pre-defined countries
     */
    public function getCountries()
    {
        return [
            "AF" => "Afghanistan",
            "AX" => "Aland Islands",
            "AL" => "Albania",
            "DZ" => "Algeria",
            "AS" => "American Samoa",
            "AD" => "Andorra",
            "AO" => "Angola",
            "AI" => "Anguilla",
            "AQ" => "Antarctica",
            "AG" => "Antigua And Barbuda",
            "AR" => "Argentina",
            "AM" => "Armenia",
            "AW" => "Aruba",
            "AU" => "Australia",
            "AT" => "Austria",
            "AZ" => "Azerbaijan",
            "BS" => "Bahamas",
            "BH" => "Bahrain",
            "BD" => "Bangladesh",
            "BB" => "Barbados",
            "BY" => "Belarus",
            "BE" => "Belgium",
            "BZ" => "Belize",
            "BJ" => "Benin",
            "BM" => "Bermuda",
            "BT" => "Bhutan",
            "BO" => "Bolivia",
            "BA" => "Bosnia And Herzegovina",
            "BW" => "Botswana",
            "BV" => "Bouvet Island",
            "BR" => "Brazil",
            "IO" => "British Indian Ocean Territory",
            "BN" => "Brunei Darussalam",
            "BG" => "Bulgaria",
            "BF" => "Burkina Faso",
            "BI" => "Burundi",
            "KH" => "Cambodia",
            "CM" => "Cameroon",
            "CA" => "Canada",
            "CV" => "Cape Verde",
            "KY" => "Cayman Islands",
            "CF" => "Central African Republic",
            "TD" => "Chad",
            "CL" => "Chile",
            "CN" => "China",
            "CX" => "Christmas Island",
            "CC" => "Cocos (Keeling) Islands",
            "CO" => "Colombia",
            "KM" => "Comoros",
            "CG" => "Congo",
            "CD" => "Democratic Republic of Congo",
            "CK" => "Cook Islands",
            "CR" => "Costa Rica",
            "CI" => "Cote D\"Ivoire",
            "HR" => "Croatia",
            "CU" => "Cuba",
            "CY" => "Cyprus",
            "CZ" => "Czech Republic",
            "DK" => "Denmark",
            "DJ" => "Djibouti",
            "DM" => "Dominica",
            "DO" => "Dominican Republic",
            "EC" => "Ecuador",
            "EG" => "Egypt",
            "SV" => "El Salvador",
            "GQ" => "Equatorial Guinea",
            "ER" => "Eritrea",
            "EE" => "Estonia",
            "ET" => "Ethiopia",
            "FK" => "Falkland Islands (Malvinas)",
            "FO" => "Faroe Islands",
            "FJ" => "Fiji",
            "FI" => "Finland",
            "FR" => "France",
            "GF" => "French Guiana",
            "PF" => "French Polynesia",
            "TF" => "French Southern Territories",
            "GA" => "Gabon",
            "GM" => "Gambia",
            "GE" => "Georgia",
            "DE" => "Germany",
            "GH" => "Ghana",
            "GI" => "Gibraltar",
            "GR" => "Greece",
            "GL" => "Greenland",
            "GD" => "Grenada",
            "GP" => "Guadeloupe",
            "GU" => "Guam",
            "GT" => "Guatemala",
            "GG" => "Guernsey",
            "GN" => "Guinea",
            "GW" => "Guinea-Bissau",
            "GY" => "Guyana",
            "HT" => "Haiti",
            "HM" => "Heard Island & Mcdonald Islands",
            "VA" => "Holy See (Vatican City State)",
            "HN" => "Honduras",
            "HK" => "Hong Kong",
            "HU" => "Hungary",
            "IS" => "Iceland",
            "IN" => "India",
            "ID" => "Indonesia",
            "IR" => "Islamic Republic Of Iran",
            "IQ" => "Iraq",
            "IE" => "Ireland",
            "IM" => "Isle Of Man",
            "IL" => "Israel",
            "IT" => "Italy",
            "JM" => "Jamaica",
            "JP" => "Japan",
            "JE" => "Jersey",
            "JO" => "Jordan",
            "KZ" => "Kazakhstan",
            "KE" => "Kenya",
            "KI" => "Kiribati",
            "KR" => "Korea",
            "XK" => "Kosovo",
            "KW" => "Kuwait",
            "KG" => "Kyrgyzstan",
            "KP" => "North Korea",
            "LA" => "Lao People\"s Democratic Republic",
            "LV" => "Latvia",
            "LB" => "Lebanon",
            "LS" => "Lesotho",
            "LR" => "Liberia",
            "LY" => "Libyan Arab Jamahiriya",
            "LI" => "Liechtenstein",
            "LT" => "Lithuania",
            "LU" => "Luxembourg",
            "MO" => "Macao",
            "MK" => "Macedonia",
            "MG" => "Madagascar",
            "MW" => "Malawi",
            "MY" => "Malaysia",
            "MV" => "Maldives",
            "ML" => "Mali",
            "MT" => "Malta",
            "MH" => "Marshall Islands",
            "MQ" => "Martinique",
            "MR" => "Mauritania",
            "MU" => "Mauritius",
            "YT" => "Mayotte",
            "MX" => "Mexico",
            "FM" => "Federated States Of Micronesia",
            "MD" => "Moldova",
            "MC" => "Monaco",
            "MN" => "Mongolia",
            "ME" => "Montenegro",
            "MS" => "Montserrat",
            "MA" => "Morocco",
            "MZ" => "Mozambique",
            "MM" => "Myanmar",
            "NA" => "Namibia",
            "NR" => "Nauru",
            "NP" => "Nepal",
            "NL" => "Netherlands",
            "AN" => "Netherlands Antilles",
            "NC" => "New Caledonia",
            "NZ" => "New Zealand",
            "NI" => "Nicaragua",
            "NE" => "Niger",
            "NG" => "Nigeria",
            "NU" => "Niue",
            "NF" => "Norfolk Island",
            "MP" => "Northern Mariana Islands",
            "NO" => "Norway",
            "OM" => "Oman",
            "PK" => "Pakistan",
            "PW" => "Palau",
            "PS" => "Palestinian Territory, Occupied",
            "PA" => "Panama",
            "PG" => "Papua New Guinea",
            "PY" => "Paraguay",
            "PE" => "Peru",
            "PH" => "Philippines",
            "PN" => "Pitcairn",
            "PL" => "Poland",
            "PT" => "Portugal",
            "PR" => "Puerto Rico",
            "QA" => "Qatar",
            "RE" => "Reunion",
            "RO" => "Romania",
            "RU" => "Russian Federation",
            "RW" => "Rwanda",
            "BL" => "Saint Barthelemy",
            "SH" => "Saint Helena",
            "KN" => "Saint Kitts And Nevis",
            "LC" => "Saint Lucia",
            "MF" => "Saint Martin",
            "PM" => "Saint Pierre And Miquelon",
            "VC" => "Saint Vincent And Grenadines",
            "WS" => "Samoa",
            "SM" => "San Marino",
            "ST" => "Sao Tome And Principe",
            "SA" => "Saudi Arabia",
            "SN" => "Senegal",
            "RS" => "Serbia",
            "SC" => "Seychelles",
            "SL" => "Sierra Leone",
            "SG" => "Singapore",
            "SK" => "Slovakia",
            "SI" => "Slovenia",
            "SB" => "Solomon Islands",
            "SO" => "Somalia",
            "XS" => "Somaliland",
            "ZA" => "South Africa",
            "GS" => "South Georgia And Sandwich Isl.",
            "SS" => "South Sudan",
            "ES" => "Spain",
            "LK" => "Sri Lanka",
            "SD" => "Sudan",
            "SR" => "Suriname",
            "SJ" => "Svalbard And Jan Mayen",
            "SZ" => "Swaziland",
            "SE" => "Sweden",
            "CH" => "Switzerland",
            "SY" => "Syrian Arab Republic",
            "TW" => "Taiwan",
            "TJ" => "Tajikistan",
            "TZ" => "Tanzania",
            "TH" => "Thailand",
            "TL" => "Timor-Leste",
            "TG" => "Togo",
            "TK" => "Tokelau",
            "TO" => "Tonga",
            "TT" => "Trinidad And Tobago",
            "TN" => "Tunisia",
            "TR" => "Turkey",
            "TM" => "Turkmenistan",
            "TC" => "Turks And Caicos Islands",
            "TV" => "Tuvalu",
            "UG" => "Uganda",
            "UA" => "Ukraine",
            "AE" => "United Arab Emirates",
            "GB" => "United Kingdom",
            "US" => "United States",
            "UM" => "United States Outlying Islands",
            "UY" => "Uruguay",
            "UZ" => "Uzbekistan",
            "VU" => "Vanuatu",
            "VE" => "Venezuela",
            "VN" => "Viet Nam",
            "VG" => "Virgin Islands, British",
            "VI" => "Virgin Islands, U.S.",
            "WF" => "Wallis And Futuna",
            "EH" => "Western Sahara",
            "YE" => "Yemen",
            "ZM" => "Zambia",
            "ZW" => "Zimbabwe",
            "X" => "Unknown"
        ];
    }
}
