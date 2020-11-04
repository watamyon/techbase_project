<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-5</title>
</head>
<body>
    <?php
        /*変数をまとめてある*/
        $filename="github_m3-5.txt";
        $name = $_POST["name"];
        $text = $_POST["text"];
        $first = $_POST['first'];
        $password = $_POST["password"];//password用
        $dpassword = $_POST["dpassword"];
        $epassword =  $_POST["epassword"];
        $editnum = $_POST["editnum"];//(編集の時に使う？)
        $edit = $_POST['edit'];//(編集の時に使う？)
        $deletenum = $_POST["deletenum"];
        $delete = $_POST["delete"];
        $second = $_POST["enumber"];//(編集の時に使う？)
        $date = date("Y/m/d H:i:s");
        $lines = file($filename,FILE_IGNORE_NEW_LINES);
        /* ここまで */
        
        /*編集②*/
        //名前とテキストとパスワードが存在するときにnew postと出力
        if($name!="" && $text!="" && $password !=""){
            echo "new post"."<br>";
        //もし編集番号が指定されたら
            if($second){
                //fileを上書きモードで開く
                $fp = fopen($filename,"w");
                //配列に戻したfile$linesを$lineに代入する
                foreach ($lines as $line){
                    //投稿番号を取得するために分解
                    $slist = explode("<>",$line);
                    //投稿番号と編集番号が一致したときに
                    if((int)$slist[0] == $second){
                    //番号と受け取った値に新しい値を書き込むために$変数を指定する
                    $str = $slist[0]."<>".$name."<>".$text."<>".$date."<>".$password."<>";//追加した
                    fwrite($fp,$str."\n");
                    
                    }else{
                        
                    //編集しなければそのまま戻す
                    $str = $slist[0]."<>".$slist[1]."<>".$slist[2]."<>".$slist[3]."<>".$slist[4]."<>";//追加した
                    fwrite($fp,$str."\n");
                    
                    }
                }//foreachのやつ
            
            //編集番号がなくてpasswordが存在する時は新規投稿
            }elseif(isset($password)){
                    //新規投稿の場合
                    //配列を最終要素にセットする
                    $last = end($lines);
                    //最終行に+1する
                    $count = (int)$last + 1;
                    //配列の内部要素を最初に戻す
                    $last = reset($lines);
                    //行数をカウントして名前とテキストと日付とパスワードを表示する
                    $str = $count."<>".$name."<>".$text."<>".$date."<>".$password."<>";//追加した
                    //fileを追記モードで開く
                    $fp = fopen($filename,"a");
                    //fileに書き込んで終了
                    fwrite($fp,$str."\n");
                    //fileを閉じる
                    fclose($fp);
                    
            }
        
        //削除番号が存在するとき    
        }elseif($deletenum !=""){
            
            //fileが存在したら
            if(file_exists($filename)){
                //fileを配列に戻す
                $lines = file($filename,FILE_IGNORE_NEW_LINES);
                //fileを上書きモードで開く
                $fp = fopen($filename,"w");
                //配列を行で取り出して変数に代入
                foreach ($lines as $line){
                    //行を要素に分解する
                    $dellist = explode("<>",$line);
                    
                    //投稿番号と削除番号が違うなら
                    if((int)$dellist[0] != $deletenum){
                        //そのまま戻す
                        $str = $dellist[0]."<>".$dellist[1]."<>".$dellist[2]."<>".$dellist[3]."<>".$dellist[4]."<>";//追加した
                        //fileに書き込む
                        fwrite($fp, $str."\n");
                    }
                    //削除番号が存在して、削除番号が既存の投稿番号と一致したとき
                    if($deletenum !="" && $deletenum == $dellist[0]){
                    //削除パスワードが既存のパスワードと異なるときに投稿をそのままも戻す。
                    if($dpassword != $dellist[4]){
                        $str = $dellist[0]."<>".$dellist[1]."<>".$dellist[2]."<>".$dellist[3]."<>".$dellist[4]."<>";
                        fwrite($fp, $str."\n");
                        echo "password error"."<br>";
                    }
                        
                    }
                }
            }
            
        }elseif(isset($editnum) && isset($edit)){
            //ループ入るごとに処理をリセットする
            //""文字を入れるのは、文字列を入れるよと知らせるため
            $enumber = "";
            $ename = "";
            $ecomment = "";
            $edpassword =""; 
            //もしfileが存在したら
            if(file_exists($filename)){
              //fileを配列にする
              $lines = file($filename,FILE_IGNORE_NEW_LINES);
              //上書きモードで開く
              $fp = fopen($filename,"w");
               //配列を各行に代入
               foreach ($lines as $line){
                //1行を要素に分解して番号を参照している
                $editlist = explode("<>",$line);
                 //もし投稿番号が編集番号と一致した場合
                 if((int)$editlist[0] == $editnum){
                   // $edpassword = $editlist[4];//pass
                   //$edpasswordに元のパスワードで$epassword認証
                    if($epassword == $editlist[4]){//追加した
                            
                    $enumber = $editlist[0];//投稿番号
                    $ename = $editlist[1];//名前
                    $ecomment = $editlist[2];//コメント
                    $edpassword = $editlist[4];//password//追加した
                            
                            
                    }else{echo "password error"."<br>";//追加した
                        
                    //変数に分解した$editlistを代入
                        
                   }
                        
                 }
                    //元に戻して↓は触らない
                    //これは値を取り出しているだけ
                    $str = $editlist[0]."<>".$editlist[1]."<>".$editlist[2]."<>".$editlist[3]."<>".$editlist[4]."<>";
                    //fileに書き込む
                    fwrite($fp, $str."\n");
              }
            }
        }
        
        if(file_exists($filename)){
        $items = file($filename,FILE_IGNORE_NEW_LINES);
         foreach($items as $item){
          $cut =explode("<>",$item);
          $count = $cut[0];
          $name = $cut[1];
          $txt = $cut[2];
          $date = $cut[3];
          echo $count." ".$name." ".$txt." ".$date. "<br>";
        //一つ一つの動作をechoで出力すると問題の原因がわかる
         }
            
        }
        
    ?>
    <form action="" method="post">
        <input type="text" name = "name" value = "<?php echo "$ename"; ?>"><br>
        <input type="text" name = "text" value ="<?php echo "$ecomment"; ?>"><br>
        <input type="password" name ="password" placeforlder = "password" value="<?php echo "$edpassword";?>"><br>
        <input type="submit" name = "first"><br>  
        編集用:<input type = "number" name = "enumber" value = "<?php echo "$enumber"; ?>">
    </form>
    
    <form action="" method="post">
        <input type = "number" name = "deletenum" placeholder = "削除対象番号"><br>
        <input type= "password" name ="dpassword" placeforlder = "password"><br>
        <input type = "submit" name = "delete" placeholder = "削除"><br>
    </form>
    
    <form action="" method="post">
        <input type = "number" name = "editnum" placeholder = "編集対象番号"><br>
        <input type="password" name ="epassword" placeforlder = "password"><br>
        <input type = "submit" name = "edit" placeholder = "編集"><br>
    </form>
</body>