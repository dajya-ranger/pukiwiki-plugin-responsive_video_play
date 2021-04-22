# pukiwiki-plugin-responsive_video_play

PukiWiki用レスポンシブ対応各種動画再生プラグイン

- 暫定公開版です（[PukiWiki1.5.2](https://pukiwiki.osdn.jp/?PukiWiki/Download/1.5.2)及び[PukiWiki1.5.3](https://pukiwiki.osdn.jp/?PukiWiki/Download/1.5.3)で動作確認済）
- 本プラグインを利用することで、次の各種動画の幅とアライメント（左寄せ・中央寄せ・右寄せ）指定でレスポンシブ表示・再生することが可能です
	- YouTube（再生開始位置・自動再生・ループ再生指定可）
	- Vimeo（自動再生・ループ再生指定可）
	- ニコニコ動画（再生開始位置指定可）
- プラグインの設置に関しては自サイトの記事「[【YouTube・Vimeo・ニコ動】PukiWiki用レスポンシブ対応動画再生プラグインを導入する！](https://dajya-ranger.com/pukiwiki/responsive-video-play-plugin/)」を参照して下さい
- 自動再生（autoオプション）やループ再生（loopオプション）を指定した場合、その組み合わせや使用ブラウザによって、またはスマホ等のモバイルデバイスでは自動再生がされない場合があります
- すでに以前のバージョンを導入済みの場合は、プラグインファイルを差し替えるだけでバージョンアップ作業が完了します
- **Ver0.1.1**からの変更点は次の通り
	- パラメータ設定用（初期値）の設定によって、プラグインのアライメント引数オプションが有効にならないケースが発生するバグを対処
- **Ver0.1.0**からの変更点は次の通り
	- 各プラグインにHTML要素クラス名の設定を追加し、プラグイン独自のCSSでスタイル変更を可能にした（各プラグインのHTML要素クラス名を同一に設定することで、各プラグインのCSSでのスタイルを統一することも可能）
