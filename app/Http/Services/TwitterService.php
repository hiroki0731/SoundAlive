<?php

namespace App\Http\Services;

use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterService
{
    // Twitter投稿
    public function tweet($concert)
    {
        $detailInfo = json_decode($concert->detail_info);
        $twitter = new TwitterOAuth(
            env('TWITTER_CLIENT_ID'),
            env('TWITTER_CLIENT_SECRET'),
            env('TWITTER_CLIENT_ID_ACCESS_TOKEN'),
            env('TWITTER_CLIENT_ID_ACCESS_TOKEN_SECRET')
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
