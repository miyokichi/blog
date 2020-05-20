<?php

namespace view;

class Head
{
    public static function output($title, $abstract)
    {
        ?>

        <head>
            <meta charset="utf-8">
            <meta name="robots" content="index,follow" />
            <title>
                <?=$title?>
            </title>
            <meta name="description" content="<?=$abstract?>" />
            <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
            <meta http-equiv="X-UA-Compatible" content="IE=Edge">

            <link rel="shortcut icon" href="ファイル名.ico">

            <!-- 外部ファイルの読み込み -->
            <link rel="stylesheet" href="/css/style.css">
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Anton&display=swap">
            <script src="/js/app.js"></script>
            <script src="/js/indexGenerater.js"></script>

            <!-- facebookのOGPタグ -->
            <!--
            <meta property="og:site_name" content="サイト名" />
            <meta property="og:url" content="ページURL" />
            <meta property="og:type" content="ページタイプ" />
            <meta property="og:title" content="ページタイトル" />
            <meta property="og:description" content="ページ説明文" />
            <meta property="og:image" content="サムネイル画像URL" />
            <meta property="fb:app_id" content="appIdを入力" />
            <meta property="og:locale" content="ja_JP" />
            -->

            <!-- twitterのOGPタグ -->
            <!--
            <meta name="twitter:card" content="カードの種類" />
            <meta name="twitter:site" content="@ユーザー名" />
            <meta name="twitter:description" content="ページ説明文" />
            <meta name="twitter:image:src" content="サムネイル画像URL" />
            -->

        </head>

        <?php
    }
}
