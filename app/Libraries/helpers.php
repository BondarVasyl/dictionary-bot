<?php


/**
 * Translate the given message.
 * Wrapper for default trans (Lang::get) method
 *
 * @param  string $id
 * @param  array  $parameters
 * @param  string $domain
 * @param  string $locale
 *
 * @return string
 */

use Illuminate\Support\Str;

if (!function_exists('дl')) {
    /**
     * @param        $id
     * @param array  $parameters
     * @param string $domain
     * @param null   $locale
     *
     * @return string
     */
    function l($id, $parameters = [], $domain = 'messages', $locale = null)
    {
        return trans($id, $parameters, $domain, $locale);
    }
}


if (!function_exists('ed')) {
    /**
     * Dump the passed variables.
     *
     * @param  mixed
     *
     * @return void
     */
    function ed(...$args)
    {
        foreach ($args as $x) {
            (new Illuminate\Support\Debug\Dumper)->dump($x);
        }
    }
}

/**
 * print_r and die
 *
 * @param string $elem
 */
function prd($elem = '')
{
    pr($elem);

    die;
}

/**
 * print_r variable
 *
 * @param string $elem
 */
function pr($elem = '')
{
    echo '<hr><pre>';

    print_r($elem);

    echo '</pre><hr>';
}

/**
 * Show last query to database
 */
if (!function_exists('get_last_query')) {
    /**
     * @return mixed
     */
    function get_last_query()
    {
        $queries = \DB::getQueryLog();

        $sql = end($queries);

        if (!empty($sql['bindings'])) {
            $pdo = \DB::getPdo();

            foreach ($sql['bindings'] as $binding) {
                $sql['query'] =
                    preg_replace(
                        '/\?/',
                        $pdo->quote($binding),
                        $sql['query'],
                        1
                    );
            }
        }

        return $sql['query'];
    }
}

if (!function_exists('active_class')) {
    /**
     * @param              $pattern
     * @param string       $class
     * @param string|array $exclude
     *
     * @return string
     */
    function active_class($pattern, $class = 'active', $exclude = '')
    {
        $pattern = str_replace('.', '\.', $pattern);
        if (strpos($pattern, '*')) {
            $pattern = str_replace('*', '', $pattern);

            $result = route_is("^$pattern") ? true : false;
        } else {
            $result = route_is("^$pattern$") ? true : false;
        }

        $_result = false;

        if ($exclude) {
            foreach ((array) $exclude as $_pattern) {
                $_pattern = str_replace('.', '\.', $_pattern);
                if (strpos($_pattern, '*')) {
                    $_pattern = str_replace('*', '', $_pattern);

                    $_result = route_is("^$_pattern") ? true : false;
                } else {
                    $_result = route_is("^$_pattern$") ? true : false;
                }

                if ($_result) {
                    break;
                }
            }
        }

        return $result && !$_result ? $class : '';
    }
}

if (!function_exists('getExtension')) {

    /**
     * @param $filename
     * @return false|mixed|string
     */
    function getExtension($filename)
    {
        $temp = explode( '.', $filename );
        return end( $temp );
    }
}

if (!function_exists('front_active_class')) {
    /**
     * @param        $pattern
     * @param string $class
     *
     * @return string
     */
    function front_active_class($pattern, $class = 'active')
    {
        $current = trim(Request::root().Request::getPathInfo(), '/');

        $pattern = str_replace(['/', '.'], ['\/', '\.'], $pattern);

        return preg_match("/$pattern/", $current) ? $class : '';
    }
}

if (!function_exists('get_model_by_controller')) {
    /**
     * @param $class
     *
     * @return string
     */
    function get_model_by_controller($class)
    {
        $class = explode('\\', str_replace('Controller', '', $class));

        return array_pop($class);
    }
}

if (!function_exists('get_templates')) {
    /**
     * @param string $parent_folder
     * @param bool   $from_files
     *
     * @return array
     */
    function get_templates($parent_folder = '', $from_files = false)
    {
        $templates = [];

        if ($parent_folder !== '' && File::exists($parent_folder)) {
            $items = $from_files ? File::files($parent_folder) : File::directories($parent_folder);

            if (count($items)) {
                foreach ($items as $template) {
                    $template = explode('/', $template);
                    $template = array_last($template);

                    if ($from_files) {
                        $template = explode('.', $template);
                        $template = array_first($template);
                    }

                    $templates[$template] = $template;
                }
            }
        }

        return $templates;
    }
}

if (!function_exists('get_layout_positions')) {
    /**
     * @param string $parent_folder
     *
     * @return array
     */
    function get_layout_positions($parent_folder)
    {
        $positions = [];

        $pattern = "widget__banner\(\'([a-zA-Z0-9_]+)\'.*";

        $finder = new \Symfony\Component\Finder\Finder();
        $finder->in($parent_folder)->name('*.php')->files();
        foreach ($finder as $file) {
            if (preg_match_all("/$pattern/siU", $file->getContents(), $matches)) {
                foreach ($matches[1] as $key) {
                    $positions[] = $key;
                }
            }
        }

        $positions = array_unique($positions);

        return $positions;
    }
}

if (!function_exists('route_is')) {
    /**
     * @param string $pattern
     *
     * @return boolean
     */
    function route_is($pattern)
    {
        return (preg_match("/$pattern/", \Route::currentRouteName())) ? true : false;
    }
}

if (!function_exists('check_local')) {
    /**
     * @param null $url
     *
     * @return bool
     */
    function check_local($url = null)
    {
        $url = $url ? : Request::root();

        return get_url_host($url) == get_url_host(route('home'));
    }
}

if (!function_exists('get_url_host')) {
    /**
     * @param string $url
     *
     * @return string
     */
    function get_url_host($url)
    {
        preg_match('/^((http[s]?|ftp):\/\/)?(www\.)?([\w\-\.]+)(\/)?(.*)$/i', $url, $host);

        if (!empty($host)) {
            return !empty($host[4]) ? $host[4] : $url;
        }

        return $url;
    }
}

if (!function_exists('get_hashed_url')) {
    /**
     * @param        $model
     * @param string $type
     * @param string $key_field
     *
     * @return string
     */
    function get_hashed_url($model, $type = 'page', $key_field = 'slug')
    {
        return md5($type.'_'.$model->id.'_'.$model->{$key_field});
    }
}

if (!function_exists('theme_asset')) {
    /**
     * @param string $path
     *
     * @return string
     */
    function theme_asset($path = '')
    {
        return $path ? Theme::asset($path) : '';
    }
}

if (!function_exists('thumb')) {
    /**
     * @param string   $path
     * @param int      $width
     * @param int|null $height
     *
     * @return string
     *
     */
    function thumb($path = '', $width = null, $height = null)
    {
        $thumb = null;

        if (URL::isValidUrl($path)) {
            return $path;
        }

        $height = $height ? : $width;
        $path = File::exists(public_path($path)) ? $path : null;

        if ($path) {
            if (!$width) {
                $img_info = getimagesize(public_path($path));

                $width = $img_info[0];
                $height = $img_info[1];
            } elseif ($width && $height) {
                $img_info = getimagesize(public_path($path));

                if (!empty($img_info)) {
                    $width = $width <= $img_info[0] ? $width : $img_info[0];
                    $height = $height <= $img_info[1] ? $height : $img_info[1];
                }
            }

            $thumb = url(Thumb::thumb(public_path($path), $width, $height)->link());
        }

        return $thumb ? : '';
    }
}

if (!function_exists('add_get_parameters')) {
    /**
     * @param array $parameters
     * @param null  $url
     *
     * @return string
     */
    function add_get_parameters($parameters, $url = null)
    {
        $newParametersArray = [];
        $parameters = array_merge($_GET, $parameters);

        foreach ($parameters as $name => $parameter) {
            $newParametersArray[] = "$name=$parameter";
        }

        sort($newParametersArray);

        $url = $url ? : Request::url();

        return $url.'?'.implode('&', $newParametersArray);
    }
}

if (!function_exists('update_get_parameters')) {
    /**
     * @param array $parameters
     * @param null  $url
     *
     * @return string
     */
    function update_get_parameters($parameters, $url = null)
    {
        $newParametersArray = [];
        $_keys = [];
        $_parameters = $_GET;

        foreach ($_parameters as $_parameter => $_value) {
            if (isset($parameters[$_parameter])) {
                $_value = explode(',', $_value);
                $_value = array_merge($_value, (array) $parameters[$_parameter]);
                $_value = implode(',', $_value);
            }

            $newParametersArray[] = $_parameter.'='.$_value;
            $_keys = $_parameter;
        }

        $parameters = array_except($parameters, $_keys);
        foreach ($parameters as $parameter => $value) {
            $newParametersArray[] = $parameter.'='.implode(',', (array) $value);
        }

        sort($newParametersArray);

        $url = $url ? : Request::url();

        return $url.'?'.implode('&', $newParametersArray);
    }
}

if (!function_exists('remove_get_parameters')) {
    /**
     * @param array $parameters
     * @param null  $url
     *
     * @return string
     */
    function remove_get_parameters($parameters, $url = null)
    {
        $newParametersArray = [];
        $_parameters = $_GET;

        foreach ($_parameters as $_parameter => $_value) {
            $_value = explode(',', $_value);

            if (isset($parameters[$_parameter])) {
                $_value = array_filter(
                    $_value,
                    function ($v) use ($parameters, $_parameter) {
                        return $v != $parameters[$_parameter];
                    }
                );
            }

            if (!empty($_value)) {
                $newParametersArray[] = $_parameter.'='.implode(',', $_value);
            }
        }

        sort($newParametersArray);

        $url = $url ? : Request::url();

        return count($newParametersArray) ? $url.'?'.implode('&', $newParametersArray) : $url;
    }
}

if (!function_exists('remove_get_parameter')) {
    /**
     * @param string $parameter
     * @param null   $url
     *
     * @return string
     */
    function remove_get_parameter($parameter, $url = null)
    {
        $newParametersArray = [];
        $_parameters = $_GET;

        foreach ($_parameters as $_parameter => $_value) {
            if ($_parameter != $parameter) {
                $newParametersArray[] = $_parameter.'='.$_value;
            }
        }

        sort($newParametersArray);

        $url = $url ? : Request::url();

        return count($newParametersArray) ? $url.'?'.implode('&', $newParametersArray) : $url;
    }
}

if (!function_exists('in_get')) {
    /**
     * @param string $parameter
     * @param string $value
     *
     * @return bool
     */
    function in_get($parameter = '', $value = '')
    {
        $values = isset($_GET[$parameter]) ? $_GET[$parameter] : null;

        if (!$values) {
            return false;
        }

        $values = explode(',', $values);

        if (!in_array($value, $values)) {
            return false;
        }

        return true;
    }
}

if (!function_exists('get_class_name_from_namespace')) {
    /**
     * @param string|Object $object
     *
     * @return string
     */
    function get_class_name_from_namespace($object)
    {
        if (is_object($object)) {
            $object = class_basename($object);
        }

        $object = explode('\\', $object);

        return array_pop($object);
    }
}

if (!function_exists('studly_camel_case')) {
    /**
     * @param string
     *
     * @return string
     */
    function studly_camel_case($string)
    {
        return studly_case(camel_case($string));
    }
}

if (!function_exists('make_locales_fakers')) {
    /**
     * @return array
     */
    function make_locales_fakers()
    {
        $fakers = [];

        foreach (config('app.locales') as $locale) {
            $fakers[$locale] = Faker\Factory::create(
                config('laravellocalization.supportedLocales.'.$locale.'.regional')
            );
        }

        return $fakers;
    }
}

if (!function_exists('variable')) {
    /**
     * Get / set the specified variable value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param  array|string $key
     * @param  mixed        $default
     *
     * @return mixed
     */
    function variable($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('variable');
        }

        return app('variable')->get($key, $default);
    }
}

if (!function_exists('template_menu')) {
    /**
     * Get / set the specified template_menu.
     *
     * @param  string $layout_position
     *
     * @return mixed
     * @throws \Illuminate\Container\EntryNotFoundException
     */
    function template_menu($layout_position)
    {
        if (is_null($layout_position)) {
            return app('template_menu');
        }

        return app('template_menu')->get($layout_position);
    }
}

if (!function_exists('is_front')) {
    /**
     * @return bool
     */
    function is_front()
    {
        if (php_sapi_name() == 'cli') {
            return false;
        }

        return !is_admin_panel();
    }
}

if (!function_exists('is_admin_panel')) {
    /**
     * @return bool
     */
    function is_admin_panel()
    {
        if (php_sapi_name() == 'cli') {
            return false;
        }

        return request()->segment(1) == '9a654138bc7c1c48fba1d0b5ca526a28';
    }
}

if (!function_exists('carbon')) {
    /**
     * @return \Carbon\Carbon
     */
    function carbon()
    {
        return new Carbon\Carbon();
    }
}

if (!function_exists('random_string')) {
    /**
     * Create a Random String
     *
     * Useful for generating passwords or hashes.
     *
     * @access    public
     *
     * @param    string  $type // of random string.  basic, alpha, all, numeric, no_zero, unique, md5, encrypt and sha1
     * @param    integer $length number of characters
     *
     * @return    string
     */
    function random_string($type = 'all', $length = 8)
    {
        switch ($type) {
            case 'basic':
                return mt_rand();
                break;

            case 'all':
            case 'numeric':
            case 'no_zero':
            case 'alpha':
            case 'alpha_num':
            case 'lover_alpha_num':
                switch ($type) {
                    case 'lover_alpha_num':
                        $pool = '0123456789abcdefghijklmnopqrstuvwxyz';
                        break;
                    case 'alpha':
                        $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        break;
                    case 'alpha_num':
                        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        break;
                    case 'numeric':
                        $pool = '0123456789';
                        break;
                    case 'no_zero':
                        $pool = '123456789';
                        break;
                    default:
                        $pool = '!@#$%^&*()_+/|\?.,><~`=-0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                }

                $str = '';
                for ($i = 0; $i < $length; $i++) {
                    $str .= substr($pool, mt_rand(0, strlen($pool) - 1), 1);
                }

                return $str;

                break;

            case 'unique':
            case 'md5':
                return md5(uniqid(mt_rand()));

                break;

            case 'encrypt':
            case 'sha1':
                return hash('sha1', uniqid(mt_rand(), true));

                break;
        }
    }
}

if (!function_exists('array_to_str')) {
    /**
     * @param  array     $array
     * @param string|int $parent_key
     *
     * @return string
     */
    function array_to_str($array, $parent_key = '')
    {
        if (!is_array($array)) {
            return $array;
        }

        $str = '';

        foreach ($array as $key => $item) {
            $str .= ($parent_key ? $parent_key.'.'.$key : $key).' = '.
                (
                !is_array($item) ?
                    '"'.($item).'"; ' :
                    array_to_str($item, $parent_key ? $parent_key.'.'.$key : $key)
                );
        }

        return $str;
    }
}

if (!function_exists('getallheaders')) {
    function getallheaders()
    {
        $headers = '';

        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $key = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))));

                $headers[$key] = $value;
            }
        }

        return $headers;
    }
}

if (!function_exists('_log')) {
    /**
     * simple log
     */
    function _log()
    {
        $data = func_get_args();

        \Log::critical(
            isset($data['message']) ? $data['message'] : 'Simple Log',
            is_array($data) ? $data : [$data]
        );
    }
}

if (!function_exists('wallet_in_menu_class')) {
    /**
     * @param string $type
     *
     * @return string
     */
    function wallet_in_menu_class(string $type)
    {
        switch ($type) {
            case 'funds':
                $type = 'founds';

                break;
            case 'commission':
                $type = 'comis';

                break;
            case 'trade':
                $type = 'trade';

                break;
        }

        return $type;
    }
}

if (!function_exists('wallet_page_class')) {
    /**
     * @param string $type
     *
     * @return string
     */
    function wallet_page_class(string $type)
    {
        switch ($type) {
            case 'funds':
                $type = 'green';

                break;
            case 'commission':
                $type = 'blue';

                break;
            case 'trade':
                $type = 'red';

                break;
        }

        return $type;
    }
}

if (!function_exists('localize_url')) {
    /**
     * @param null|string $url
     * @param null|string $locale
     *
     * @return string
     */
    function localize_url($url = null, $locale = null)
    {
        $locale = $locale ? : app()->getLocale();
        $url = $url ? ($url == '/' ? route('home') : $url) : URL::full();

        return check_local($url) ? LaravelLocalization::getLocalizedURL($locale, $url) : $url;
    }
}

if (!function_exists('admin_emails')) {
    /**
     * @param array $email
     *
     * @return \Illuminate\Support\Collection
     */
    function admin_emails($email = [])
    {
        $emails = implode(',', $email).','.variable('admin_emails');

        return collect(explode(',', $emails))
            ->map(
                function ($item) {
                    return trim($item);
                }
            )
            ->filter(
                function ($item) {
                    return filter_var($item, FILTER_VALIDATE_EMAIL);
                }
            );
    }
}

if (!function_exists('transaction_type_class')) {
    /**
     * @param string $type
     *
     * @return string
     */
    function transaction_type_class(string $type)
    {
        switch ($type) {
            case 'receive':
                $type = 'green';

                break;
            case 'spend':
                $type = 'red';

                break;
        }

        return $type;
    }
}
    if (!function_exists('dircopy')) {
        /**
         * @param string $srcdir
         * @param string $dstdir
         * @param bool $verbose
         *
         * @return string
         */
        function dircopy($srcdir, $dstdir, $verbose = false)
        {
            $ds = DIRECTORY_SEPARATOR;
            $num = 0;
            if(!is_dir($dstdir)) mkdir($dstdir);
            if($curdir = opendir($srcdir)) {
                while($file = readdir($curdir)) {
                    if($file != '.' && $file != '..') {
                        $srcfile = $srcdir . $ds . $file;
                        $dstfile = $dstdir . $ds . $file;
                        if(is_file($srcfile)) {
                            if(is_file($dstfile)) $ow = filemtime($srcfile) - filemtime($dstfile); else $ow = 1;
                            if($ow > 0) {
                                if($verbose) echo "Copying \'$srcfile\' to \'$dstfile\'...";
                                if(copy($srcfile, $dstfile)) {
                                    touch($dstfile, filemtime($srcfile)); $num++;
                                    if($verbose) echo "OKn \n";
                                }
                                else echo "Error: File \'$srcfile\' could not be copied!n";
                            }
                        }
                        else if(is_dir($srcfile)) {
                            $num += dircopy($srcfile, $dstfile, $verbose);
                        }
                    }
                }
                closedir($curdir);
            }
        }
    }
if (!function_exists('words_limit')) {
    /**
     * @param string $input_text
     * @param int $limit
     * @param mixed $end_str
     *
     * @return string
     */
    function words_limit($input_text, $limit = 50, $end_str = '')
    {
        $input_text = strip_tags($input_text);
        $input_text = str_replace('\n',"",$input_text);
        $words = explode(' ', $input_text);
        if ($limit < 1 || sizeof($words) <= $limit) {
            return $input_text;
        }
        $words = array_slice($words, 0, $limit);
        $out = implode(' ', $words);
        return trim($out) . $end_str;
    }
}

if(!function_exists('detect_locale')) {
    function detect_locale($locale): string
    {
        if ($locale == 'en') {
            return 'us';
        }

        if ($locale == 'uk') {
            return 'ua';
        }

        return $locale;
    }
}

if (!function_exists('file_url')) {

    function file_url($string): ?string
    {
        if ($string) {
            if (!str_contains($string, 'http')) {
                return  str_contains($string, 'storage/') ? asset($string) : asset('storage/'.$string);
            }

            return $string;
        }

        return null;
    }
}

if (!function_exists('declension_word')) {

    function declension_word($number, $word): ?string
    {
        $ar= array (2, 0, 1, 1, 1, 2);

        return $word[ ($number%100 > 4 && $number%100 < 20) ? 2 : $ar[min($number%10, 5)] ];
    }
}

if (!function_exists('generate_file_hash')) {

    function generate_file_hash($id = null): string
    {
        return $id ? $id . '-' . Str::random() : Str::random();
    }
}
