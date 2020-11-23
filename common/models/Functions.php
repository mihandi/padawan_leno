<?php

namespace common\models;

class Functions
{

    public static function pretty_var_dump($var, $args = array())
    {
        $defautls = array(
            'before_table_text' => '',
            'min_width' => 250,
            'skip_int_indices' => false,
            'dump_values' => true,
            'depth' => 0,
            'max-depth' => 10,
            'echo' => true,
            'show_classes_names' => true,
            'cut_keys' => false,
        );
        if (!is_array($args)) {
            $args = array();
        }
        $args = array_merge($defautls, $args);
        $args['depth'] = !empty($args['depth']) ? $args['depth'] + 1 : 1;
        $echo = $args['echo'];
        $args['echo'] = true;
        $classname_str = "";
        if (is_object($var)):
            if ($args['show_classes_names']):
                $classname_str = "<u><i>object</i>(<b>" . get_class($var) . "</b>)</u>\n";
            endif;
            $var = (array)$var;
            $color = '#00CC00';
        else: $color = '#333';
        endif;
        if ($echo === false) {
            ob_start();
        }
        if (!defined("PRETTY_VAR_DUMP_STYLES")) {
            define("PRETTY_VAR_DUMP_STYLES", 1);
            echo
            "<script>
function rightCellToggleCollapsed(){
    el = event.path[1];
    var next_td = el.nextElementSibling;
    el.classList.toggle('collapsed_parent');
    next_td.classList.toggle('collapsed');
}
</script>
<style>
    .pretty_var_dump__table { min-width:{$args['min_width']}px; width: auto; padding: 0; margin: 0; }
    .pretty_var_dump__table tr { border-bottom: 1px #AAA dotted; }
    .pretty_var_dump__table td { padding:1px; line-height: 1; }
    .pretty_var_dump__table td:first-child { text-align: right; position: relative; padding-left: 20px; }
    .pretty_var_dump__table td:first-child .corner_icon {
        position: absolute; top: 1px; left: 1px; text-align: center;
        height: calc(1em - 2px); width: calc(1em - 2px);
        border: 1px solid transparent; background-color: #EEE; cursor: pointer;
    }
    .corner_icon:before { content: '-';}
    .collapsed_parent .corner_icon:before { content: '+'; }
    .pretty_var_dump__table td:first-child .corner_icon:hover { border:1px solid #B8B8B8; }
    .pretty_var_dump__table td:nth-child(2) { border-left: 2px #4444FF dotted;}
    .pretty_var_dump__table td:first-child:hover { background-color: #DDD; }
    .pretty_var_dump__table pre { white-space: pre-line; padding:0; margin: 0; border: 0; line-height: 1; overflow: initial;}
    .pretty_var_dump__table .collapsed { display: none; }
    .pretty_var_dump__table .collapsed_parent { background-color: #CCC; }
</style>\n";
        }
        if ($args['depth'] == 1) {
            echo $args['before_table_text'];
        }
        $spaces = 6 * ($args['depth'] - 1);
        if (is_array($var)):
            echo str_pad("", $spaces, " ") . "$classname_str<table class=\"pretty_var_dump__table\""
                . " style='border:2px solid $color; min-width:{$args['min_width']}px;'>\n"
                . str_pad("", $spaces + 2, " ") . "<tbody>\n";
            if (empty($var)):
                echo "<tr><td style='text-align: center; font-size: 10px; '><i>empty array</i></td></tr>";
            endif;
            foreach ($var as $k => $v):
                if (!is_int($k) || !$args['skip_int_indices']):
                    if ($args['cut_keys']):
                        $k = (strlen($k) > $args['cut_keys'] + 2) ? ("<span title='$k'>" . substr(
                                $k,
                                0,
                                $args['cut_keys']
                            ) . "..</span>") : $k;
                    endif;
                    $collapse_btn = !is_null($v) && !is_scalar(
                        $v
                    ) ? "<div class='corner_icon' onclick='rightCellToggleCollapsed()'></div>\n" : "";
                    echo str_pad("", $spaces + 2, " ") . "<tr class='depth-{$args['depth']}'>\n"
                        . str_pad("", $spaces + 4, " ") . "<td>\n"
                        . $collapse_btn
                        . str_pad("", $spaces + 6, " ") . "[" . (is_int($k) ? "(int)" : "") . $k . "]"
                        . "<span onclick='rightCellToggleCollapsed()'>=&gt;</span>\n"
                        . str_pad("", $spaces + 4, " ") . "</td>\n"
                        . str_pad("", $spaces + 4, " ") . "<td>\n";
                    if ($args['depth'] < $args['max-depth']):
                        self::pretty_var_dump($v, $args);
                    else:
                        echo "<pre><b>Max depth reached!</b></pre>";
                    endif;
                    echo str_pad("", $spaces + 4, " ") . "</td>\n"
                        . str_pad("", $spaces + 2, " ") . "</tr><!--depth-{$args['depth']}-->\n";
                endif;
            endforeach;
            echo str_pad("", $spaces + 2, " ") . "</tbody>\n"
                . str_pad("", $spaces, " ") . "</table>\n";
        elseif (is_bool($var) || is_null($var)):
            echo str_pad("", $spaces, " ") . "<pre>";
            var_dump($var);
            echo str_pad("", $spaces, " ") . "</pre>\n";
        else:
            if ($args['dump_values']):
                echo str_pad("", $spaces, " ") . "<pre>";
                var_dump(htmlentities($var));
                echo str_pad("", $spaces, " ") . "</pre>\n";
            else:
                echo str_pad("", $spaces, " ") . htmlentities($var) . "\n";
            endif;
        endif;
        if ($echo === false) {
            $result = ob_get_contents();
            ob_end_clean();
            return $result;
        }
    }

    public static function arrayItem($array, $item, $default = null)
    {
        if (is_array($item)) {
            $element = $array;
            foreach ($item as $key) {
                if (is_object($element) && isset($element->$key)) {
                    $element = $element->$key;
                } elseif (isset($element[$key])) {
                    $element = $element[$key];
                } else {
                    return $default;
                }
            }
            return $element;
        }
        if (is_object($array)) {
            return isset($array->$item) ? $array->$item : $default;
        }
        return isset($array[$item]) ? $array[$item] : $default;
    }

    public static function getSeoUrl($title)
    {
        $cyr = [
            'а',
            'б',
            'в',
            'г',
            'д',
            'е',
            'ё',
            'ж',
            'з',
            'и',
            'й',
            'к',
            'л',
            'м',
            'н',
            'о',
            'п',
            'р',
            'с',
            'т',
            'у',
            'ф',
            'х',
            'ц',
            'ч',
            'ш',
            'щ',
            'ъ',
            'ы',
            'ь',
            'э',
            'ю',
            'я',
            'А',
            'Б',
            'В',
            'Г',
            'Д',
            'Е',
            'Ё',
            'Ж',
            'З',
            'И',
            'Й',
            'К',
            'Л',
            'М',
            'Н',
            'О',
            'П',
            'Р',
            'С',
            'Т',
            'У',
            'Ф',
            'Х',
            'Ц',
            'Ч',
            'Ш',
            'Щ',
            'Ъ',
            'Ы',
            'Ь',
            'Э',
            'Ю',
            'Я',
            ' ',
            '"',
            '<',
            '>',
            '?',
            '!',
            '@',
            '#',
            '$',
            '%',
            '^',
            '&',
            '*',
            '/',
            '*',
            '+',
            '.',
            '(',
            ')',
            '_',
            '=',
            '«',
            '»',
            ',',
            '[',
            ']',
            '{',
            '}',
            '\'',
            'є',
            'Є',
            'Ї',
            'ї'
        ];
        $lat = [
            'a',
            'b',
            'v',
            'g',
            'd',
            'e',
            'io',
            'zh',
            'z',
            'i',
            'y',
            'k',
            'l',
            'm',
            'n',
            'o',
            'p',
            'r',
            's',
            't',
            'u',
            'f',
            'h',
            'ts',
            'ch',
            'sh',
            'sht',
            'a',
            'i',
            'y',
            'e',
            'yu',
            'ya',
            'A',
            'B',
            'V',
            'G',
            'D',
            'E',
            'Io',
            'Zh',
            'Z',
            'I',
            'Y',
            'K',
            'L',
            'M',
            'N',
            'O',
            'P',
            'R',
            'S',
            'T',
            'U',
            'F',
            'H',
            'Ts',
            'Ch',
            'Sh',
            'Sht',
            'A',
            'I',
            'Y',
            'e',
            'Yu',
            'Ya',
            '-',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            'ie',
            'ie',
            'ie',
            'ie'
        ];

        $latniza_str = str_replace($cyr, $lat, $title);

        return $latniza_str;
    }

    public static function custom_mkdir($path, $mode = 0777, $recursive = false)
    {
        $old = umask(0);
        mkdir($path, $mode, $recursive);
        umask($old);
        chmod($path, $mode);
    }

}