# wget2doc

- PHPでスクレイピングします。
- コマンド(wget/find)に依存しています。

ドメインからwget -> ローカルに保存 -> ページタイトルを抽出 -> Googleスプレッドシートにアップロード 

## Usage

.envに以下を設定します。

```
APP_NAME=wget2doc
WGET_DOMAIN=example.com
GOOGLE_APPLICATION_CREDENTIALS='jsonファイルのパス'
SPREAD_SHEET_ID='スプレッドシートのID'__
SPREAD_SHEET_NAME = 'シートの名称'

```

コマンドラインより実行

```
$ php wget2doc.php
```

## カスタマイズなど

- wgetで取得刷るファイルは、app/Wget2doc/Wget.php で指定していますので変更可能。
- スプレッドシートにアップするファイルなどは、実行ファイル(wget2doc.php)で $outputを生成しているループで随時変更




