<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>Аутентификация через Google</title>
</head>
<body>
<?php
$client_id = '393366204033.apps.googleusercontent.com'; // Client ID
$client_secret = '0qAnUQAlU_VZH4ZeZrT1uq4z'; // Client secret
$redirect_uri = 'http://nixx.no-ip.org/api'; // Redirect URIs

$url = 'https://accounts.google.com/o/oauth2/auth';

$params = array(
    'redirect_uri'  => $redirect_uri,
    'response_type' => 'code',
    'client_id'     => $client_id,
    'scope'         => 'https://www.googleapis.com/auth/admin.directory.group.readonly '
);

echo $link = '<p><a href="' . $url . '?' . urldecode(http_build_query($params)) . '">Аутентификация</a></p>';

if (isset($_GET['code'])) {
    $params = array(
        'client_id'     => $client_id,
        'client_secret' => $client_secret,
        'redirect_uri'  => $redirect_uri,
        'grant_type'    => 'authorization_code',
        'code'          => $_GET['code']
    );
    $url = 'https://accounts.google.com/o/oauth2/token';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($curl);
    curl_close($curl);
    $tokenInfo = json_decode($result, true);

    if (isset($tokenInfo['access_token'])) {
     echo '<a href="groups.php?token=' . $tokenInfo['access_token'] . '">Состав групп</a></br>';
     echo '<a href="groups2.php?token=' . $tokenInfo['access_token'] . '">Состав групп c названиями</a></br>';
     echo '<a href="rgroups.php?token=' . $tokenInfo['access_token'] . '">Состав групп c названиями (redmine формат)</a></br>';
    }
}
?>
</body>
</html>