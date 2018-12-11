<?php

namespace Tests\Unit\Http\Helpers;

use App\Http\Helpers\Helper;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class helperTest extends TestCase
{

    /**************************************************
     *
     * 以下、getStationNameのテスト
     *
     **************************************************/

    public function test_getStationName_NG_NoCode()
    {
        $helper = app()->make(Helper::class);

        // 存在しない駅コードの場合
        $stationCode = 99999999;
        $result = $helper::getStationName($stationCode);
        $this->assertEquals('データなし', $result);
    }

    public function test_getStationName_NG_NotNumericCode()
    {
        $helper = app()->make(Helper::class);

        // 駅コードが数値でない場合
        $stationCode = 'ABCDEFG';
        $result = $helper::getStationName($stationCode);
        $this->assertEquals('データなし', $result);
    }

    public function test_getStationName_NG_nullReturnedFromCacheRemember()
    {
        $helper = app()->make(Helper::class);

        // Cache::rememberでnullが返ってきた場合
        $stationCode = 1130203;
        Cache::shouldReceive('remember')
            ->once()
            ->andReturn(null);
        $result = $helper::getStationName($stationCode);
        $this->assertEquals('データなし', $result);
    }

    public function test_getStationName_NG_CannotParseXml()
    {
        $helper = app()->make(Helper::class);

        // Cache::rememberで値が返ってきたがXMLに変換できない場合
        $stationCode = 1130203;
        Cache::shouldReceive('remember')
            ->once()
            ->andReturn('Just a string');
        $result = $helper::getStationName($stationCode);
        $this->assertEquals('データなし', $result);
    }

    public function test_getStationName_OK()
    {
        $helper = app()->make(Helper::class);

        // 目黒駅のコードを入れた正常パターン
        $stationCode = 1130203;
        $result = $helper::getStationName($stationCode);
        $this->assertEquals('目黒', $result);
    }


    /**************************************************
     *
     * 以下、getLineNameのテスト
     *
     **************************************************/

    public function test_getLineName_NG_NoCode()
    {
        $helper = app()->make(Helper::class);

        // 存在しない駅コードの場合
        $lineCode = 99999999;
        $result = $helper::getLineName($lineCode);
        $this->assertEquals('データなし', $result);
    }

    public function test_getLineName_NG_NotNumericCode()
    {
        $helper = app()->make(Helper::class);

        // 駅コードが数値でない場合
        $lineCode = 'ABCDEFG';
        $result = $helper::getLineName($lineCode);
        $this->assertEquals('データなし', $result);
    }

    public function test_getLineName_NG_nullReturnedFromCacheRemember()
    {
        $helper = app()->make(Helper::class);

        // Cache::rememberでnullが返ってきた場合
        $lineCode = 1130203;
        Cache::shouldReceive('remember')
            ->once()
            ->andReturn(null);
        $result = $helper::getLineName($lineCode);
        $this->assertEquals('データなし', $result);
    }

    public function test_getLineName_NG_CannotParseXml()
    {
        $helper = app()->make(Helper::class);

        // Cache::rememberで値が返ってきたがXMLに変換できない場合
        $lineCode = 1130203;
        Cache::shouldReceive('remember')
            ->once()
            ->andReturn('Just a string');
        $result = $helper::getLineName($lineCode);
        $this->assertEquals('データなし', $result);
    }

    public function test_getLineName_OK()
    {
        $helper = app()->make(Helper::class);

        // JR山手線のコードを入れた正常パターン
        $lineCode = 11302;
        $result = $helper::getLineName($lineCode);
        $this->assertEquals('JR山手線', $result);
    }

    /**************************************************
     *
     * 以下、getStationsByLineのテスト
     *
     **************************************************/

    public function test_getStationsByLine_NG_NoCode()
    {
        $helper = app()->make(Helper::class);

        // 存在しない駅コードの場合
        $lineCode = 99999999;
        $result = $helper::getStationsByLine($lineCode);
        $this->assertEquals([], $result);
    }

    public function test_getStationsByLine_NG_NotNumericCode()
    {
        $helper = app()->make(Helper::class);

        // 駅コードが数値でない場合
        $lineCode = 'ABCDEFG';
        $result = $helper::getStationsByLine($lineCode);
        $this->assertEquals([], $result);
    }

    public function test_getStationsByLine_NG_nullReturnedFromCacheRemember()
    {
        $helper = app()->make(Helper::class);

        // Cache::rememberでnullが返ってきた場合
        $lineCode = 1130203;
        Cache::shouldReceive('remember')
            ->once()
            ->andReturn(null);
        $result = $helper::getStationsByLine($lineCode);
        $this->assertEquals([], $result);
    }

    public function test_getStationsByLine_NG_CannotParseXml()
    {
        $helper = app()->make(Helper::class);

        // Cache::rememberで値が返ってきたがXMLに変換できない場合
        $lineCode = 1130203;
        Cache::shouldReceive('remember')
            ->once()
            ->andReturn('Just a string');
        $result = $helper::getStationsByLine($lineCode);
        $this->assertEquals([], $result);
    }

    public function test_getStationsByLine_OK()
    {
        $helper = app()->make(Helper::class);

        $url = 'http://www.ekidata.jp/api/l/11302.xml';

        // 予想データ用意
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        $tmp = curl_exec($ch);

        $expectedXML = simplexml_load_string($tmp);
        $expectedArray = get_object_vars($expectedXML);

        // JR山手線のコードを入れた正常パターン
        $lineCode = 11302;
        $result = $helper::getStationsByLine($lineCode);
        $this->assertEquals($expectedArray['station'], $result);
    }

    /**************************************************
     *
     * 以下、getPrefのテスト
     *
     **************************************************/

    public function test_getPref_OK()
    {
        $helper = app()->make(Helper::class);

        $result = $helper::getPref();
        $this->assertEquals(Config::get('const.prefecture'), $result);
    }

    /**************************************************
     *
     * 以下、getMusicTypeのテスト
     *
     **************************************************/

    public function test_getMusicType_OK()
    {
        $helper = app()->make(Helper::class);

        $result = $helper::getMusicType();
        $this->assertEquals(Config::get('const.music_type'), $result);
    }

    /**************************************************
     *
     * 以下、getPrefNameのテスト
     *
     **************************************************/

    public function test_getPrefName_NG_NoCode()
    {
        $helper = app()->make(Helper::class);

        $result = $helper::getPrefName(0);
        $this->assertEquals('データなし', $result);
    }

    public function test_getPrefName_NG_IllegalCode()
    {
        $helper = app()->make(Helper::class);

        $result = $helper::getPrefName('ABCDEFG');
        $this->assertEquals('データなし', $result);
    }

    /**************************************************
     *
     * 以下、getMusicTypeNameのテスト
     *
     **************************************************/

    public function test_getMusicTypeName_NG_NoCode()
    {
        $helper = app()->make(Helper::class);

        $result = $helper::getMusicTypeName(0);
        $this->assertEquals('データなし', $result);
    }

    public function test_getMusicTypeName_NG_IllegalCode()
    {
        $helper = app()->make(Helper::class);

        $result = $helper::getMusicTypeName('ABCDEFG');
        $this->assertEquals('データなし', $result);
    }

    /**************************************************
     *
     * 以下、getGoogleMapKeyのテスト
     *
     **************************************************/

    public function test_getGoogleMapKey()
    {
        $helper = app()->make(Helper::class);

        $result = $helper::getGoogleMapKey();
        $this->assertEquals(Config::get('keys.google_map'), $result);
    }
}