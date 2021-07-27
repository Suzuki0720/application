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
//count = プレイリストの最大数
$count = 10;
$youtube_url1 = null;
$youtube_url2 = null;
$youtube_url3 = null;
$youtube_url4 = null;
$youtube_url5 = null;
$youtube_url6 = null;
$youtube_url7 = null;
$youtube_url8 = null;
$youtube_url9 = null;
$youtube_url10 = null;
$youtube_urlsafe = null;
$youtube_url = null;
$message = array();
$message_array = array();
$error_message = array();
$clean = array();

//入力されたURLからvideoIDの抽出
for($i = 1; $i < 11; $i++){
if(isset($_REQUEST["url_name".$i.""]) == true)
{
	/** 入力内容を取得 */
	$url = ${'youtube_url'.$i.''} = $_REQUEST["url_name".$i.""];

	$url = htmlspecialchars($url, ENT_QUOTES);

	if (strpos(${'youtube_url'.$i.''}, "watch") != false)	/* ページURL ? */
	{
		/** コードを変換 */
		${'youtube_url'.$i.''} = substr(${'youtube_url'.$i.''}, (strpos(${'youtube_url'.$i.''}, "=")+1));
	}
	else
	{
		/** 短縮URL用を変換 */
		${'youtube_url'.$i.''} = substr(${'youtube_url'.$i.''}, (strpos(${'youtube_url'.$i.''}, "youtu.be/")+9));
	}
}
}

//videoIDに=が含まれていたとき、そのvideoIDを後ろに持ってくる
for($j = 1; $j <= $count; $j++){
 if(strpos(${'youtube_url'.$j.''}, '=') !== false){
  //k = プレイリストの最大数
  for($k = 10; $k > 0; $k++){
   if(strpos(${'youtube_url'.$k.''}, '=') !== false){
  }else{
   $youtube_urlsafe = ${'youtube_url'.$j.''};
   ${'youtube_url'.$j.''} = ${'youtube_url'.$count.''};
   ${'youtube_url'.$count.''} = $youtube_urlsafe;
   $count--;
   break;
  }
 }
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
    
    if( empty($_POST['url_name1']) ) {
		$error_message[] = 'URLを入れてください。';
	}else {
		$clean['url_name1'] = htmlspecialchars( $_POST['url_name1'], ENT_QUOTES, 'UTF-8');
	}

    if(empty($error_message)){
    if($file_handle = fopen(FILENAME,"a")){
        //書き込み日時を取得
        $current_date = date("Y-m-d H:i:s");
        //書き込むデータを作成
        $data = "'".$clean['list_name']."','".$clean['view_name']."','".$youtube_url1."','".$youtube_url2."','".$youtube_url3."','".$youtube_url4."','".$youtube_url5."','".$youtube_url6."','".$youtube_url7."','".$youtube_url8."','".$youtube_url9."','".$youtube_url10."','".$clean['message']."','".$current_date."'\n";
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
            'url_name1' => $split_data[5],
	    'url_name2' => $split_data[7],
	    'url_name3' => $split_data[9],
	    'url_name4' => $split_data[11],
	    'url_name5' => $split_data[13],
	    'url_name6' => $split_data[15],
	    'url_name7' => $split_data[17],
	    'url_name8' => $split_data[19],
	    'url_name9' => $split_data[21],
	    'url_name10' => $split_data[23],
            'message' => $split_data[25],
            'post_date' => $split_data[27]
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
	<label for="view_name">投稿者名</label>
	<input id="view_name" type="text" name="view_name" value="">
	</div>
	    
    	<div>
        <label for="list_name">プレイリスト名</label>
	<input id="list_name" type="text" name="list_name" value="">
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
		<li><input id="url_name" type="text" name="url_name1" value=""></li>
		<li><input id="url_name" type="text" name="url_name2" value=""></li>
		<li><input id="url_name" type="text" name="url_name3" value=""></li>
		<li><input id="url_name" type="text" name="url_name4" value=""></li>
		<li><input id="url_name" type="text" name="url_name5" value=""></li>
		<li><input id="url_name" type="text" name="url_name6" value=""></li>
		<li><input id="url_name" type="text" name="url_name7" value=""></li>
		<li><input id="url_name" type="text" name="url_name8" value=""></li>
		<li><input id="url_name" type="text" name="url_name9" value=""></li>
		<li><input id="url_name" type="text" name="url_name10" value=""></li>
        </ul>
	    
	<div>
		<label for="message">ひと言メッセージ</label>
		<textarea id="message" name="message"></textarea>
	</div>
	    
<style>
	
  li{
    list-style: none;
  }
	
	
  .addInput{
	backgroud: #fff;
	padding: 10px;
	text-align: center;
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
      position: absolute; top:200px; left:300px;
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
    opacity: 0.8;
  }
	
#view_name:hover{
    opacity: 1.0;
  }

  #url_name{
    border-color: #94D6DA;
    border-radius: 10%;
    border-style: solid;
    opacity: 0.8;
  }
	
#url_name:hover{
    opacity: 1.0;
  }

  #list_name{
    border-color: #94D6DA;
    border-radius: 10%;
    border-style: solid;
    opacity: 0.8;
  }
	
#list_name:hover{
    opacity: 1.0;
  }

  #message{
    border-color: #94D6DA;
    border-radius: 10%;
    opacity: 0.8;
  }	  

#message:hover{
    opacity: 1.0;
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
            src=https://www.youtube.com/embed?playlist=<?php echo $value['url_name1'];?>,<?php echo $value['url_name2'];?>,<?php echo $value['url_name3'];?>,<?php echo $value['url_name4'];?>,<?php echo $value['url_name5'];?>,<?php echo $value['url_name6'];?>,<?php echo $value['url_name7'];?>,<?php echo $value['url_name8'];?>,<?php echo $value['url_name9'];?>,<?php echo $value['url_name10'];?>
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
　　 position: relative; left: 40px;
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
