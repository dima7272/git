<html>
<body>
<?
$params['access_token'] = $_GET['token'];
//$params['domain'] = 'happylab.ru';
$params['customer'] = 'my_customer';

$groupInfo = json_decode(file_get_contents('https://www.googleapis.com/admin/directory/v1/groups' . '?' . urldecode(http_build_query($params))), true);

$today = date("j m Y");
echo 'h2. Список всех групповых адресов<br />';
echo '_Обновлено ' . $today.'_ </br>';

echo'<table border="1">';
echo'|_.Название группы|_.Адрес группы|_.Список получателей|';
    foreach ($groupInfo as $value) {
        if( is_array($value)){
             foreach($value as $arr){
                echo'</br>';
                echo'|'.$arr['name'];
                echo'|'.$arr['email'];
                $users = json_decode(file_get_contents('https://www.googleapis.com/admin/directory/v1/groups/' . $arr['email'] .'/members' .'?'. urldecode(http_build_query($params))),true);
                $col=true;
                    foreach ($users as $value2) {
                        if( is_array($value2)){
                        echo '|';
                            foreach($value2 as $arr2){
                                if ($col) {echo $arr2['email'];}
                                else {echo ', ' . $arr2['email'];}
                                $col=false;
                            }

                        echo '|';
                        }

                    }
                if($col) echo '| - |';

             }
        }
    }
    echo '</table>';
?>
</boby>
</html>