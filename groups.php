<html>
<body>
<?
$params['access_token'] = $_GET['token'];
//$params['domain'] = 'happylab.ru';
$params['customer'] = 'my_customer';

$groupInfo = json_decode(file_get_contents('https://www.googleapis.com/admin/directory/v1/groups' . '?' . urldecode(http_build_query($params))), true);

echo'<table border="1">';
    foreach ($groupInfo as $value) {
        if( is_array($value)){
             foreach($value as $arr){
                echo'<tr>';
                echo'<td>'.$arr['email'] . '</td>';
                $users = json_decode(file_get_contents('https://www.googleapis.com/admin/directory/v1/groups/' . $arr['email'] .'/members' .'?'. urldecode(http_build_query($params))),true);
                $col=true;
                    foreach ($users as $value2) {
                        if( is_array($value2)){
                        echo '<td>';
                            foreach($value2 as $arr2){
                                $col=false;
                                echo $arr2['email'].'<br />';

                            }

                        echo '</td>';
                        }

                    }
                if($col) echo '<td>&nbsp;</td>';

             }
            echo'</tr>';
        }
    }
    echo '</table>';
?>
</boby>
</html>