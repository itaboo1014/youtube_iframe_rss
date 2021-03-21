<?php
//出力するHTMLを変数に格納する設定
$output = '';
//フィードのURLをセット
$feed='https://www.youtube.com/feeds/videos.xml?channel_id=xxxxxxxxxxxxxxxxxxxxxxxx';//24桁のyoutubeユーザーIDを（xxx）部分に入力
//フィードを読み込み
$xml = simplexml_load_file($feed);
//配列に変換
$obj = get_object_vars($xml);
//動画情報を変数に格納
$obj_entry = $obj["entry"];
//動画のトータル件数を取得
$total = count($obj_entry);
//動画が存在するかどうかチェック
if( $total != 0 ){
	//for文でブン回す
	for ($i=0; $i < $total; $i++) { 
		foreach ($obj_entry[$i] as $key => $value) {
			if( in_array($key, array('id','title')) ){//キーがidかtitleの場合
				if( $key=='id'){
					//動画IDを変数に格納（yt:video:XXXXという形式なので手前の文字列を置換処理も挟む）
					$video_id = str_replace('yt:video:', '', $value[0]);
				}elseif( $key=='title' ){
					//動画タイトルを変数に格納
					$video_title = $value[0];
				}
			}else{
				continue;//残りの処理をスキップ
			}
		}
		//リスト形式で出力
		$output .= '<div class="sp-slide">';
		$output .= '<iframe width="100%" height="100%" src="https://www.youtube.com/embed/'.$video_id.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>';//動画IDを使ってURLを組み立て
		$output .= '</iframe>';
		$output .= '</div>';
	}
	//出力する内容を格納
	echo '<div class="sp-slides">'. $output . '</div>';
}
?>