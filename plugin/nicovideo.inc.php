<?php

/**
 * nicovideo.inc.php
 *
 * PukiWiki用レスポンシブ対応ニコニコ動画再生プラグイン
 *
 * @author		オヤジ戦隊ダジャレンジャー <red@dajya-ranger.com>
 * @copyright	Copyright © 2021, dajya-ranger.com
 * @link		https://dajya-ranger.com/pukiwiki/responsive-video-plugin/
 * @example		#nicovideo(動画ID,[width=ピクセル指定],[left|center|right],[start=再生開始位置（秒指定）])
 * @example		&nicovideo(動画ID,[width=ピクセル指定],[left|center|right],[start=再生開始位置（秒指定）]);
 * @license		Apache License 2.0
 * @version		0.1.0
 * @since 		0.1.0 2021/01/14 暫定公開
 *
 */

/* 一般的な動画サイズ（解像度）一覧
	2160p：3840×2160（4K）
	1440p：2560×1440（2K）
	1080p：1920×1080（FullHD）
	 720p：1280× 720（HD）
	 480p： 720× 480（SD）
	 360p： 640× 360
	 240p： 426× 240
*/

function plugin_nicovideo_params($args) {
	// 引数チェック＆パラメータ設定用
	$params = array(
		'id'		=> '',				// 動画ID
		'width'		=> 720,				// 動画幅（ピクセル）
		'start'		=> 0,				// 再生開始位置（秒）
		'left'		=> TRUE,			// 左寄せ
		'center'	=> FALSE,			// 中央寄せ
		'right'		=> FALSE,			// 右寄せ
		'_error'	=> ''				// エラー内容
	);

										// 引数チェック
	if ( isset($args[0]) && ($args[0] != '') ) {
		// 動画IDセット
		$params['id'] = array_shift($args);
	} else {
		// 第1引数が存在しない
		$params['_error'] = '動画IDが指定されていません';
		return $params;
	}
	// 動画IDを設定したタイミングで引数を小文字に変換する
	$args = array_map('strtolower', $args);
	if ( isset($args[0]) && ($args[0] != '') ) {
		// 第2引数以降が存在する
		foreach ($args as $arg) {
			$val = explode("=", $arg);
			if ($val[0] != '') {
				if (! (isset($params[$val[0]])) ) {
					// オプション名と一致しない場合
					$params['_error'] = '引数の指定にエラーがあります ' . $val[0];
					return $params;
				}
			}
		}
	}
										// パラメータセット
	if (! empty($args)) {
		foreach ($args as $arg) {
			$val = explode("=", $arg);
			if (isset($params[$val[0]])) {
				// 指定された引数がオプション名と一致する場合
				switch ($val[0]) {
				case 'left':
				case 'center':
				case 'right':
					$params[$val[0]] = TRUE;
					break;
				case 'width':
				case 'start':
					if (isset($val[1]) && ($val[1] != '')) {
						// 動画幅・再生開始位置指定がある場合
						$params[$val[0]] = $val[1];
						break;
					} else {
						// 動画幅・再生開始位置指定がない場合
						$params['_error'] = '引数の指定にエラーがあります ' . $arg;
						return $params;
					}
				}
			}
		}
	}

	return $params;
}

function plugin_nicovideo_make_html($params) {
	// 動画ID
	$id = $params['id'];
	// 動画幅
	$width = $params['width'] . "px";
	// 再生開始位置
	$start = ($params['start'] > 0)? '?from=' . $params['start'] : '';
	// アライメント
	if ($params['center']) {
		$align = '"center"';
	} else if ($params['right']) {
		$align = '"right"';
	} else {
		$align = '"left"';
	}
	// ソースURL編集
	$src = '"https://embed.nicovideo.jp/watch/' . $id . $start . '"';

	$body = <<<EOM
<div align=$align>
	<div style="max-width: $width;">
		<div style="height: 0; position: relative; padding-bottom: 56.25%;">
			<iframe style="
				position: absolute;
				width: 100%;
				height: 100%;
				left: 0;
				right: 0;
				top: 0;
				bottom: 0;"
				width="2560"
				height="1440"
				src=$src
				frameborder="0"
				allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
				allowfullscreen>
			</iframe>
		</div>
	</div>
</div>
EOM;
	return $body . "\n";
}


function plugin_nicovideo_convert() {
										// パラメータセット
	$args = func_get_args();
	$params = plugin_nicovideo_params($args);
	if (isset($params['_error']) && $params['_error'] != '') {
		// パラメータエラーがある場合
		return '#nicovideo: ' . $params['_error'] . "\n";
	}
										// HTMLコード出力
	return plugin_nicovideo_make_html($params);
}

function plugin_nicovideo_inline() {
										// パラメータセット
	$args = func_get_args();
	$params = plugin_nicovideo_params($args);
	if (isset($params['_error']) && $params['_error'] != '') {
		// パラメータエラーがある場合
		return '&nicovideo: ' . $params['_error'] . "\n";
	}
										// HTMLコード出力
	return plugin_nicovideo_make_html($params);
}
