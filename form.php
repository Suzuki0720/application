<?php
//ファイルのパス指定
define('FILENAME','./message.txt');

date_default_timezone_set('Asia/Tokyo');

// 変数の初期化
$current_date = null;
$data = null;
$file_handle = null;
$split_data = null;
$url = null;
$youtube_url = null;
$message = array();
$message_array = array();
$error_message = array();
$clean = array();


if(isset($_REQUEST["url_name"]) == true)
{
	/** 入力内容を取得 */
	$url = $youtube_url = $_REQUEST["url_name"];

	$url = htmlspecialchars($url, ENT_QUOTES);

	if (strpos($youtube_url, "watch") != false)	/* ページURL ? */
	{
		/** コードを変換 */
		$youtube_url = substr($youtube_url, (strpos($youtube_url, "=")+1));
	}
	else
	{
		/** 短縮URL用を変換 */
		$youtube_url = substr($youtube_url, (strpos($youtube_url, "youtu.be/")+9));
	}

}

if(!empty($_POST['btn_submit'])){
    //表示名の入力チェック
    if( empty($_POST['list_name']) ) {
		$error_message[] = 'プレイリスト名を入れてください。';
	}else {
		$clean['list_name'] = htmlspecialchars( $_POST['list_name'], ENT_QUOTES, 'UTF-8');
        $clean['list_name'] = preg_replace( '/\\r\\n|\\n|\\r/', '', $clean['list_name']);
	}

    if( empty($_POST['view_name']) ) {
		$clean['view_name'] = '名無しさん';
	}else {
		$clean['view_name'] = htmlspecialchars( $_POST['view_name'], ENT_QUOTES, 'UTF-8');
        $clean['view_name'] = preg_replace( '/\\r\\n|\\n|\\r/', '', $clean['view_name']);
	}

    if( !empty($_POST['message']) ) {
	$clean['message'] = htmlspecialchars( $_POST['message'], ENT_QUOTES, 'UTF-8');
        $clean['message'] = preg_replace( '/\\r\\n|\\n|\\r/', '<br>', $clean['message']);
	}
    
    if( empty($_POST['url_name']) ) {
		$error_message[] = 'URLを入れてください。';
	}else {
		$clean['url_name'] = htmlspecialchars( $_POST['url_name'], ENT_QUOTES, 'UTF-8');
	}

    if(empty($error_message)){
    if($file_handle = fopen(FILENAME,"a")){
        //書き込み日時を取得
        $current_date = date("Y-m-d H:i:s");
        //書き込むデータを作成
        $data = "'".$clean['list_name']."','".$clean['view_name']."','".$youtube_url."','".$clean['message']."','".$current_date."'\n";
        //書き込み
        fwrite( $file_handle, $data);

        fclose($file_handle);
    }
    }
}
//ファイルを読み込んでHTMLに返す
if( $file_handle = fopen( FILENAME,'r') ) {
    while( $data = fgets($file_handle) ){
        $split_data = preg_split( '/\'/', $data);

        $message = array(
            'list_name' => $split_data[1],
            'view_name' => $split_data[3],
            'url_name' => $split_data[5],
            'message' => $split_data[7],
            'post_date' => $split_data[9]
        );
        array_unshift( $message_array, $message);
    }

    // ファイルを閉じる
    fclose( $file_handle);
}
?>
<!DOCTYPE HTML>
<html lang="ja">
    <head>
        <meta charset="utf-8">
	<link href="CSS/style.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
	    <script type="text/javascript">
	    $(function(){
		var size = $('li').length;
		alert(size);
		//「+」を押したら増やす
		$('.add').click(function(){
		    $('.addInput').append('<li><input id="url_name" type="text" name="url_name[]" value=""></li>');
		});
		//「-」を押したら減らす
		$('.del').click(function(){
		    size = $('li').length
		    if(size > 1){
			$('.addInput li:last-child').remove();
		   }
		});
	    });
	    </script>
    </head>
    <body>
    <?php if( !empty($error_message) ): ?>
	    <ul class="error_message">
		    <?php foreach( $error_message as $value ): ?>
			    <li>・<?php echo $value; ?></li>
		    <?php endforeach; ?>
	    </ul>
    <?php endif; ?>
        <header>
        </header>
	    <h1>YouTubeプレイリスト掲示板</h1>
	    
	    

            <div class="box1">
              <p>プレイリスト作成＆投稿</p>
            </div>
    <form method="post">
    <div>
        <label for="list_name">プレイリスト名</label>
		<input id="list_name" type="text" name="list_name" value="">
    </div>
	<div>
		<label for="view_name">投稿者名</label>
		<input id="view_name" type="text" name="view_name" value="">
	</div>
	    
    	<div>
		<label for="url_name">URL</label>
	
	</div>
	
	<div>
		<label for="minus"></label>
		<a class="del" name="minus">－</a>
		<label for="puls"></label>
		<a class="add" name="puls">＋</a>
	</div>
	    
	    <ul class="addInput">
		<li><input id="url_name" type="text" name="url_name" value=""></li>
        </ul>
	    
	<div>
		<label for="message">ひと言メッセージ</label>
		<textarea id="message" name="message"></textarea>
	</div>
	    
<style>
	
  li{
    list-style: none;
  }
	
  .home{
      font-size: 20px;
      padding: 2px 20px;
      background-color:#0099ff;
      border-style: none;
      border-radius: 3px;
      color:#000;
      text-decoration: none;
      margin: 0 auto;
    }

  .home:hover{
      color: white;
      border-bottom: none;
    }
	
  #btnen {
      font-size: 20px;
      padding: 2px 30px;
      background-color:#0099ff;
      border-style: none;
      color:#000;
      margin-left: 91%;
    }
	
  #btnen:hover{
    color: white;
  }
	
  .del {
    width: 25px;
    height: 25px;
    background: #0099FF;
    border-radius: 100%;
    border-style: none;
    box-shadow: 1.5px 0 ;
  }

  .add {
    width: 25px;
    height: 25px;
    background: #0099FF;
    border-radius: 100%;
    border-style: none;
    box-shadow: 1.5px 0 ;
  }
	
  .del:hover,
  .add:hover{
    color: #fff;
  }
	  
#view_name{
    border-color: #94D6DA;
    border-radius: 10%;
    border-style: solid;
  }

  #url_name{
    border-color: #94D6DA;
    border-radius: 10%;
    border-style: solid;
  }

  #list_name{
    border-color: #94D6DA;
    border-radius: 10%;
    border-style: solid;
  }

  #message{
    border-color: #94D6DA;
    border-radius: 10%;
  }	  
  
</style>
	<input id="btnen" type="submit" name="btn_submit" value="投稿">
</form>
<hr>
<section>
    <?php if( !empty($message_array) ): ?>
    <?php foreach( $message_array as $value ): ?>
    <article>
        <div class="info">
            <h2><?php echo $value['view_name']; ?></h2>
            <h3><?php echo $value['list_name']; ?></h3>
            <time><?php echo date('Y年m月d日 H:i', strtotime($value['post_date'])); ?></time>
        </div>
        <div class="YouTube">
            <iframe 
            width="560" height="315" 
            src=https://www.youtube.com/embed/<?php echo $value['url_name'];?>
            title="YouTube video player" 
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
            </iframe -->
	    
	<?php
	//プレイリスト
	//nextボタンが押された時の処理
	if(isset($_POST['nextBtn'])){
	
	}
	//previousボタンが押された時の処理
	else if(isset($_POST['previousBtn'])){

	}
	?>
		
	</div>
	    
	<div>
	<button id="previousBtn" name="previousBtn"><span>戻る</span></button>  
        <button id="nextBtn" name="nextBtn"><span>次へ</span></button>
	</div>
	    
	 <a href="index.php" class="home">TOPへ</a>
	    
	    
<style>
	
  .YouTube{
    float: left;
    height: 20px;
  }

  .info{
    height: 20px;
    margin-left: 50%;

  }
	
  #previousBtn,
  #nextBtn {
    position: relative;
    display: inline-block;
    padding: 3px 10px;
    border: 2px solid #e41313;
    background: #fff;
    border-radius: 2px;
    color: #e41313;
    text-decoration: none;
    font-size: 15px;
    font-weight: bold;
    height: auto;
    margin-top: 15%;
    margin-right: 5%;

}

  #previousBtn span{
    text-align: center;
    opacity: 0.3
  }

  #nextBtn span{
    text-align: center;
    opacity: 0.3
  }

  #previousBtn span:hover{
    opacity: 1.0;
  }


  #nextBtn span:hover{
    opacity: 1.0;
  }


  </style>

	    
        <p><?php echo $value['message']; ?></p>
	    <hr>
    </article>
    <?php endforeach; ?>
    <?php endif; ?>
</section>
    </body>
</html>

<!--iframe width="560" height="315" src="https://www.youtube.com/embed/ba600DlIRAo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe -->
