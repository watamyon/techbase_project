<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-01</title>
</head>
<body>
<?php 
    // 【サンプル】
	// ・データベース名：tb219876db
	// ・ユーザー名：tb-219876
	// ・パスワード：ZzYyXxWwVv
	// の学生の場合：

	// DB接続設定
	$dsn = 'データベース名';
	$user = 'パスワード';
	$password = 'ユーザー名';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	 //投稿
    $name = $_POST["name"];
    $text = $_POST["text"];
    $date = date("Y/m/d H:i:s");
    $second = $_POST["second"];//編集につかうよ
    $pass = $_POST["pass"];
    
    //削除
    $dNum = $_POST["dNum"];
    $deletepass =$_POST["deletepass"];
    // $delete = $_POST["delete"];
    
    //編集
    $eNum = $_POST["eNum"];
    $editpass =$_POST["editpass"];
    // $edit = $_POST["edit"];
    
    if($name!= "" && $text != "" && $pass !=""){
        
        if($second == ""){
	        $sql = $pdo -> prepare("INSERT INTO phptest (name, text, date, pass) VALUES (:name, :text, :date, :pass)");
	        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
	        $sql -> bindParam(':text', $text, PDO::PARAM_STR);
	        $sql -> bindParam(':date', $date, PDO::PARAM_STR);
	        $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
	        $sql -> execute();
	        
            
	    }else{
	        
	        $id = $second;
	        $sql = 'UPDATE phptest SET name=:name,text=:text,date=:date, pass=:pass WHERE id=:id';
	        $stmt = $pdo->prepare($sql);
	        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
	        $stmt->bindParam(':text', $text, PDO::PARAM_STR);
	        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
	        $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
	        $stmt->execute();
	        $second = "";

	    }
	    
            //DB表示
            $sql = 'SELECT * FROM phptest';
            $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、 /
            $stmt->execute();                             // ←SQLを実行する。
            $results = $stmt->fetchAll(); 
            foreach ($results as $row){
	        //$rowの中にはテーブルのカラム名が入る
	        echo $row['id'].',';
	        echo $row['name'].',';
	        echo $row['text'].',';
	        echo $row['date'].',';
	        echo $row['pass'].'<br>';
	        echo "<hr>";
            }
	        
       
            
    }elseif($dNum != ""){
        //DB削除
       $dpass = "";
	   $id = $dNum;
	   $sql = 'SELECT * FROM phptest WHERE id=:id';
       $stmt = $pdo->prepare($sql);  
       $stmt->bindParam(':id', $id, PDO::PARAM_INT);
       $stmt->execute();
       $results = $stmt->fetchAll(); 
       foreach ($results as $row){
	   //$rowの中にはテーブルのカラム名が入る
	   $dpass = $row['pass'];
	   
       if($dpass == $deletepass){
         $sql = 'DELETE from phptest WHERE id=:id';
	     $stmt = $pdo->prepare($sql);
	     $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	     $stmt->execute();
         echo "削除しました"."<br>";
         $sql = 'SELECT * FROM phptest';
         $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、 /
         $stmt->execute();                             // ←SQLを実行する。
         $results = $stmt->fetchAll(); 
         foreach ($results as $row){
	     //$rowの中にはテーブルのカラム名が入る
	     echo $row['id'].',';
	     echo $row['name'].',';
	     echo $row['text'].',';
	     echo $row['date'].',';
	     echo $row['pass'].'<br>';
	     echo "<hr>";
         }
         
       }else{
         echo "password error"."<br>";
         $sql = 'SELECT * FROM phptest';
         $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、 /
         $stmt->execute();                             // ←SQLを実行する。
         $results = $stmt->fetchAll(); 
         foreach ($results as $row){
	     //$rowの中にはテーブルのカラム名が入る
	     echo $row['id'].',';
	     echo $row['name'].',';
	     echo $row['text'].',';
	     echo $row['date'].',';
	     echo $row['pass'].'<br>';
	     echo "<hr>";
         }
       }
	   
    }
       
       
	  
	   
    }elseif($eNum !=""){
        $id = $eNum;
        $epass = "";
        $second = "";
        $ename = "";
        $etext = "";
        
        $sql = 'SELECT * FROM phptest WHERE id=:id';
        $stmt = $pdo->prepare($sql);  
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(); 
        foreach ($results as $row){
	    //$rowの中にはテーブルのカラム名が入る
	    $row['pass'];
        }
	    
     if($row['pass'] == $editpass){
        
        $sql = 'SELECT * FROM phptest WHERE id=:id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(); 
        foreach ($results as $row){
	    //$rowの中にはテーブルのカラム名が入る
	    //,があると編集モードに入らない
	    $second = $row['id'].'';
	    $ename = $row['name'].'';
	    $etext = $row['text'].'';
	    $epass = $row['pass'].'';
	   }
	   
    }else{
        echo "password error"."<br>";
        $sql = 'SELECT * FROM phptest';
         $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、 /
         $stmt->execute();                             // ←SQLを実行する。
         $results = $stmt->fetchAll(); 
         foreach ($results as $row){
	     //$rowの中にはテーブルのカラム名が入る
	     echo $row['id'].',';
	     echo $row['name'].',';
	     echo $row['text'].',';
	     echo $row['date'].',';
	     echo $row['pass'].'<br>';
	     echo "<hr>";
         }
    }
    }
    //全部消したら追記を1から始めるにはどうしたらよいのか
?>

    <form action="" method="post">
    <input type="name" name="name" value="<?php echo "$ename";?>">
    <input type="text" name="text" value="<?php echo "$etext";?>">
    <input type="text" name= "pass" value="<?php echo "$epass";?>">
    <input type="submit" name="submit" value="コメント">
    <input type="number" name="second" value="<?php echo "$second";?>">
    </form>
    
    <form action="" method="post">
    <input type="number" name="dNum" placeholder="削除対象番号">
    <input type="text" name= "deletepass" value="">
    <input type="submit" name="delete" value="削除">
    </form>
    
    <form action="" method="post">
    <input type="number" name="eNum" placeholder="編集対象番号">
    <input type="text" name= "editpass" value="">
    <input type="submit" name="edit" placeholder="編集">
    </form>
</body>