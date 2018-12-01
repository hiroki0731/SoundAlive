<?php

namespace App\Http\Services;

use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Support\Facades\Config;

class TwitterService
{
    /**
     * Concert情報を受け取り、Twitterへ画像付き投稿をする
     * @param $concert
     */
    public function tweet($concert)
    {
        $detailInfo = json_decode($concert->detail_info);
        $twitter = new TwitterOAuth(
            Config::get('keys.twitter.client_id'),
            Config::get('keys.twitter.client_secret'),
            Config::get('keys.twitter.client_id_access_token'),
            Config::get('keys.twitter.client_id_access_token_secret')
        );
        $media = $twitter->upload('media/upload', ['media' => '/vagrant/src/public/storage/images/' . $detailInfo->concert_img]);

        $twitter->post("statuses/update", [
            "status" =>
                $detailInfo->concert_date . "開催！" .
                $detailInfo->band_name . "の新ライブをお見逃しなく！詳しくは下記のリンクをクリック！" . PHP_EOL .
                'http://soundalive.com/detail/' . $concert->id,
            "media_ids" => implode(',', [$media->media_id_string])
        ]);
    }
}
