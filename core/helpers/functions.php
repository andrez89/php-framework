<?php

/**
 * Require a view.
 *
 * @param  string $name
 * @param  array  $data
 */
function view($name, $data = [])
{
    extract($data);

    return require "app/views/{$name}.view.php";
}

/**
 * Redirect to a new page.
 *
 * @param  string $path
 */
function redirect($path = "")
{
    //echo $path;
    http_response_code(301);
    header("Location: /" . BASE_PATH . "{$path}");
    die();
}

function expiredSession()
{
    $url = str_replace(BASE_PATH, "", $_SERVER['REQUEST_URI']);
    $pos = strpos($url, "/");
    if ($pos !== false && $pos <= 1) {
        $url = substr_replace($url, "", 0, 1);
    }
    http_response_code(401);
    header("Location: /" . BASE_PATH . "?url=" . urlencode($url));
    die();
}

function fail_http()
{
    http_response_code(400);
    json(["result" => "KO"]);
    die();
}
/**
 * Return JSON response.
 *
 * @param  mixed $object
 */
function json($object)
{
    header('Content-Type: application/json');
    echo json_encode(utf8ize($object));
    if (json_last_error() != JSON_ERROR_NONE) {
        echo "{'JSON Error' : '" . json_last_error_msg() . "'}";
    }
}

/* Use it for json_encode some corrupt UTF-8 chars
 * useful for = malformed utf-8 characters possibly incorrectly encoded by json_encode
 */
function utf8ize($mixed)
{
    if (is_array($mixed)) {
        foreach ($mixed as $key => $value) {
            $mixed[$key] = utf8ize($value);
        }
    } elseif (is_string($mixed)) {
        return mb_convert_encoding($mixed, "UTF-8", "UTF-8");
    }
    return $mixed;
}

// -- HTTP REQUESTS --
/**
 * Send a POST requst using cURL
 * @param string $url to request
 * @param array $post values to send
 * @param array $options for cURL
 * @return string
 */
function curl_post($url, array $headers, $post = "", array $options = array())
{
    $defaults = array(
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_URL => $url,
        CURLOPT_FRESH_CONNECT => 1,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FORBID_REUSE => 1,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_SSL_VERIFYPEER => 0, // On dev server only!
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_POSTFIELDS => $post
    );

    $ch = curl_init();
    curl_setopt_array($ch, ($options + $defaults));
    if (!$result = curl_exec($ch)) {
        //var_dump(curl_error($ch));
        trigger_error(curl_error($ch));
    }
    curl_close($ch);
    return $result;
}

/**
 * Send a GET requst using cURL
 * @param string $url to request
 * @param array $get values to send
 * @param array $options for cURL
 * @return string
 */
function curl_get($url, array $headers = null, array $get = array(), array $options = array())
{
    $defaults = array(
        CURLOPT_URL => $url . (strpos($url, '?') === false ? '?' : '') . http_build_query($get),
        CURLOPT_HEADER => 0,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FRESH_CONNECT => 1,
        CURLOPT_SSL_VERIFYPEER => 0, // On dev server only!
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_TIMEOUT => 0
    );

    $ch = curl_init();
    curl_setopt_array($ch, ($options + $defaults));
    if (!$result = curl_exec($ch)) {
        trigger_error(curl_error($ch));
    }
    curl_close($ch);
    return $result;
}

function ifNull($variable, $result = "")
{
    return isset($variable) && $variable != "" ? $variable : $result;
}

function ifNoElement($array, $key, $result = "")
{
    return isset($array[$key]) ? $array[$key] : $result;
}


function getMessagePanel()
{
    return $_SESSION["color_panel"];
}

function hasMessage()
{
    return isset($_SESSION["title_message"]);
}

function getMessage($details = false)
{
    if (hasMessage()) {
        $res = "[" . $_SESSION["title_message"] .  "] ";
        if (isset($_SESSION["text_message"])) {
            $res .=  $_SESSION["text_message"];
        }
        if (isset($_SESSION["text_message"])) {
            if ($details) {
                $res .= "<p>" . $_SESSION["details_message"] . "</p>";
            } else {
                $res .= "<!-- " . $_SESSION["details_message"] . " -->";
            }
        }
        return $res;
    } else {
        return "";
    }
}

function setError($context, $message, $details = "")
{
    $_SESSION["color_panel"] = "danger";
    $_SESSION["title_message"] = $context;
    $_SESSION["text_message"] = $message;
    $_SESSION["details_message"] = $details;
}

function setOkMessage($context, $message, $details = "")
{
    $_SESSION["color_panel"] = "success";
    $_SESSION["title_message"] = $context;
    $_SESSION["text_message"] = $message;
    $_SESSION["details_message"] = $details;
}

function clearMessage()
{
    unset($_SESSION["color_panel"]);
    unset($_SESSION["title_message"]);
    unset($_SESSION["text_message"]);
    unset($_SESSION["details_message"]);
}

function uploadFile($fm, $data, $file)
{
    $fileN = uniqid();
    $filename = "uploads/" . $fileN;
    $imageFileType = strtolower(pathinfo(basename($file["name"]), PATHINFO_EXTENSION));
    $check = true; //getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if (!($check !== false)) {
        setError("Upload", "File caricato non è un immagine!");
        return false;
    }
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        setError("Upload", "Estensione {$imageFileType} non valida!");
        return false;
    }
    if (!move_uploaded_file($file["tmp_name"], $filename)) {
        setError("Upload", "Errore salvataggio immagine sul server!");
        return false;
    }

    if (!$fm->addImage(userName(), $data["cf_paz"], $fileN, ifnull($data["datP"]), ifnull($data["nota"]))) {
        setError("Save FM", "Errore salvataggio dati sul server!", getMessage(true));
        return false;
    }

    return true;
}
