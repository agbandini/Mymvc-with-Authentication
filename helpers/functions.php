<?php

function view($view, array $data = []) {
    extract($data);
    ob_start();
    require __DIR__ . '/../app/views/' . $view . '.tpl.php';
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

function redirect($url = '/') {
    header('Location:' . $url);
    exit;
}

function validateDate($date, $format = 'Y-m-d', $falseIsNull = true) {
    $d = \DateTime::createFromFormat($format, $date);
    $out = $d == '1970-01-01' ? false : true;
    $out = $d && $d->format($format) == $date;
    if (!$out) {
        if ($falseIsNull) {
            return NULL;
        } else {
            return false;
        }
    } else {
        return $date;
    }
}

function setActive($position, ...$sezione) {
    
    $url = $_SERVER['REQUEST_URI'];
    $splitUri = explode('/', substr($url, 1));
    $keys = array_keys($splitUri);
    $out = "";
    foreach ($sezione as $sez) {
        if (isset($keys[$position])) {
           
            if ($splitUri[$keys[$position]] == "" && $sez == 'home') {
                $out = "active";
                break;
            }
            if (isset($keys[$position - 1])) {
                if ($splitUri[$keys[$position]] == $sez || $splitUri[$keys[$position - 1]] == $sez) {
                    $out = "active";
                    break;
                }
            } else {
                if ($splitUri[$keys[$position]] == $sez) {
                    $out = "active";
                    break;
                }
            }
        }
    }
    return $out;
}
