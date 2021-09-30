<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-2</title>
</head>
<body>
    <form action="" method="post">
        名前:<input type="text" name="name"><br>
        コメント:<input type="text" name="comment"><br>
        <input type="submit" name="submit">
    </form>
    <?php
        $filename="mission_3-2.txt";
        
        //最終の番号取得
        if(file_exists($filename)){
            
            $fp = fopen($filename,"a");
            
            //配列に読み込み
            $lines = file($filename,FILE_IGNORE_NEW_LINES);
            fclose($fp);
            
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
        if(is_readable($filename)){
            
            //配列に読み込み
            $lines = file($filename,FILE_IGNORE_NEW_LINES);
            
            //表示
            foreach($lines as $line){
                $kakikomi = explode("<>",$line);
                echo $kakikomi[0];
                echo " 名前:" . $kakikomi[1];
                echo " 日時:" . $kakikomi[3] . "<br>";
                echo "コメント:" . $kakikomi[2] . "<br>";
            }
            
        } else {
            //ファイルが存在しないときの処理
            echo "まだ書き込みはありません<br>";
        }
        
    ?>

</body>
</html>