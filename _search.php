<?php

session_start();
include("_function.php");
loginCheck();

// データの抽出

// 選択した種類を取得

$selectcategory ='';
$selectcategory = $_POST["category"];


//DBに接続する
$pdo = db_connect();


//データ登録のSQL作成


    if($_POST['category']==='すべて'){
    $stmt = $pdo->prepare("SELECT * FROM animal_table");
    }else{
      $category = $_POST["category"];
    $stmt = $pdo->prepare("SELECT * FROM animal_table WHERE category = :selectcategory");
    $stmt ->bindValue(':selectcategory',$category);
    }


    //SQLの実行
    $status = $stmt->execute();



// if(radiobtnの値がすべてのとき)｛

// sql(where文なし)
// 実行

// ｝else if(radiobtnが全て以外のとき)｛

// $category=$_POST("category")
// sql（where文あり）
// bindvalue使う
// 実行

// ｝



// 3.データの表示
$view = "";
if($status==false){
    //execute (SQL実行時にErrorがある場合）
    $error = $stmt->errorInfo();
exit("ErrorQuery:".$error[2]);
} else {
   
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
           
           $view .='<div class="animal_box">';
           $view .='<div class="imgname_box">';
           $view .='<p>';
           $view .='<img src="'.$result["img"].'"class="a_img">';
           $view .='</p>';
           $view .='<div class="name_box">';
           $view .='<hr>';
           $view .='<p>';
           $view .='生き物のなまえ';
           $view .='</p>';
           $view .='<p class="a_name">';
           $view .=$result["a_name"];
           $view .='</p>';
           $view .='<hr>';
           $view .='<p>';
           $view .='生き物の種類';
           $view .='</p>';
           $view .='<p class="a_category">';
           $view .=$result["category"];
           $view .='</p>';
           $view .='<hr>';
           $view .='</div>';
           $view .='</div>';
           $view .='<hr>';
           $view .='<p class="kaisetu_a">';
           $view .='かいせつ';
           $view .='</p>';
           $view .='<p class="a_kaisetu">';
           $view .=$result["kaisetu"];
           $view .='</p>';  
           $view .='<hr>';
           $view .= "<a class='delete' href=delete.php?id={$result["id"]} onclick=confirm('データを削除します。本当によろしいですか？')>";
           $view .="削除";
           $view .= '</a>';
           $view .='</div>'; 
    }
}

?>

<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>生き物図鑑</title>
    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/style.css" />
    
  </head>
  <body>
  <header>
 <div class=title>
<img src="img/タイト.png" alt="ヘッダー">
</div>
    <div class="log">
        <a href="_top.php" class="top">さいしょのページに戻る</a>
        <p><?php echo h($_SESSION["u_name"]);?>さん<a href="logout.php">ログアウト</a></p>
      </div>
    </header>

    <main>

     <h2 class="formArea">生き物いちらん</h2>
    <p class="formArea"><a href="admin_form.php">→きみのしっている生き物をとうろくする←</a></p><br/><hr>
        <form method="post" action="_search.php">
          <p class="formArea">絞り込み検索 </p>


<div class="cp_ipradio">
	<input type="radio" name="category" id="a_rb1" value="ほにゅう類"/>
	<label for="a_rb1">ほにゅう類</label>
	<input type="radio" name="category" id="a_rb2" value="ちょう類"/>
	<label for="a_rb2">ちょう類</label>
	<input type="radio" name="category" id="a_rb3" value="ぎょ類"/>
	<label for="a_rb3">ぎょ類</label>
	<input type="radio" name="category" id="a_rb4" value="りょうせい類"/>
	<label for="a_rb4">りょうせい類</label>
	<input type="radio" name="category" id="a_rb5" value="その他"/>
	<label for="a_rb5">その他</label>
	<input type="radio" name="category" id="a_rb6" value="すべて"/>
	<label for="a_rb6">すべて</label>
</div>
          <p><input type="submit" class="form-Btn" value="しらべる" /></p> 
        </form>
      </div>  

      <div class="shurui">
<?php echo "生き物の種類　:　".$selectcategory; ?><br/>
</div>
      <hr>
      <div class="animal">
      <?php echo ($view)?>
      </div>

    </main>
          <footer>
  	<p>© All rights reserved by makki.</p>
  </footer>
  </body>
</html>