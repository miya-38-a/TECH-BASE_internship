<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-3</title>
</head>
<body>
    <form action="" method="post">
        名前:<input type="text" name="name"><br>
        コメント:<input type="text" name="comment"><br>
        <input type="submit" name="submit">
    </form>
    <?php
        $filename="mission_3-3.txt";
        
        //最終の番号取得
        if(file_exists($filename)){
            
            //配列に読み込み
            $lines = file($filename,FILE_IGNORE_NEW_LINES);
            
            $latest = explode("<>",$lines[count($lines)-1])[0];
        } else {
            $latest = 0;
        }
            
        //コメントと名前がPOSTされたときの処理        
        if(isset($_POST["name"]) && isset($_POST["comment"])){
            
            //コメントが空でないとき書き込み
            if($_POST["comment"] == ""){
                echo "コメントを入力してください<br>";
            } else {
                $comment = $_POST["comment"];
            
                //名前が空のときの処理
                if($_POST["name"] != ""){
                    $name = $_POST["name"];
                } else {
                    $name = "名無しさん";
                }
            
                //書き込み
                $date = date("Y/m/d/ H:i:s");
                $str = $latest+1 . "<>" . $name . "<>" . $comment . "<>" . $date;
                $fp = fopen($filename,"a");
                fwrite($fp, $str.PHP_EOL);
                fclose($fp);
            }
        }
        
        //ファイルが存在する場合の処理
        if(file_exists($filename)){
            
            //配列に読み込み
            $lines = file($filename,FILE_IGNORE_NEW_LINES);
            
            //表示
            foreach($lines as $line){
                $kakikomi = explode("<>",$line);
                echo $kakikomi[0];
                echo " 名前:" . $kakikomi[1];
                echo " 日時:" . $kakikomi[3] . "<br>";
                echo "コメント:" . $kakikomi[2] . "<br><br>";
            }
            
            
        } else {
            //ファイルが存在しないときの処理
            echo "まだ書き込みはありません<br>";
        }
    ?>
    <form action="" method="post">
        番号:<input type="number" name="sakujo">
        <input type="submit" name="submit" value="削除">
    </form>
    <?php
        //削除の処理
        if(isset($_POST["sakujo"]) && file_exists($filename)){
            $sakujo = $_POST["sakujo"];
            
            //削除対象が指定されているときだけ処理
            if($sakujo == ""){
                echo "削除対象を入力してください<br>";
            } else {
                
                //配列に読み込み
                $lines = file($filename,FILE_IGNORE_NEW_LINES);
            
                //削除対象以外を含む配列を作成
                $new_lines = array();
                foreach($lines as $line){
                    $kakikomi = explode("<>",$line);
                    if($kakikomi[0] != $sakujo){
                        array_push($new_lines, $line);
                    }
                }
                
                //一回全部消す
                $fp = fopen($filename,"w");
                fwrite($fp, "");
                fclose($fp);
                
                //書き込み
                foreach($new_lines as $line){
                    $fp = fopen($filename,"a");
                    fwrite($fp, $line . PHP_EOL);
                    fclose($fp);
                }
            echo "削除が完了しました<br>";
            }
            
        }
    ?>

</body>
</html>