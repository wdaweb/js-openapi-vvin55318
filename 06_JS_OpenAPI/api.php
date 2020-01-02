<?php
$db=new PDO("mysql:host=127.0.0.1;dbname=practice;charset=utf8","root","");

switch ($_GET['do']) {
    case 'insert':
        // 如果資料庫中有重複，不可再加入一次
        $sql="SELECT * FROM api_favorite WHERE num=".$_POST['num'];
        $result=$db->query($sql)->fetch();
        if($result)  echo "此站點已加入我的最愛";
        else {
            $sql="INSERT INTO api_favorite VALUES (null,'".$_POST['sarea']."','".$_POST['sareaen']."','".$_POST['num']."')";
            $db->query($sql);
            echo "
            <tr style='background:lightblue'>
                <td>★".$_POST['sarea']."</td>
                <td>".$_POST['sareaen']."</td>
                <td>".$_POST['num']."</td>
                <td></td>
                <td></td>
            </tr>
            ";
        }
        break;
        // 丟出資料庫資料(我的最愛)
        case 'select':
            $sql="SELECT *FROM api_favorite WHERE 1";
            $rows=$db->query($sql)->fetchAll();
            $i=0;
            $count=count($rows);
            echo "[
";
            foreach($rows as $row){
                //改丟出 num、sarea、sareaen以陣列方式到謙端改為物件
                $i++;
                echo '{"sarea":"'.$row['sarea'].'","sareaen":"'.$row['sareaen'].'","num":"'.$row['num'].'"}';
                if($i<$count) echo ",
"; 
            }
            echo "
]";
        break;
        // 刪除
        case 'delete':
            $sql="DELETE FROM api_favorite WHERE num=".$_POST['chk_nmb'];
            $db->query($sql);
        break;
}
