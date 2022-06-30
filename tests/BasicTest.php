<?php

namespace App\Tests;

use ApiTester;

class BasicTest
{
    protected string $keyFailed = '';
    protected array $testData = [];

    public function _before(ApiTester $I) {
        $this->keyFailed = '';
        $this->testData = [];
    }

    public function _failed(ApiTester $I)
    {
        if ($this->keyFailed != '') {
            echo "\n\nFailed on key: " . $this->keyFailed . "\n\n";
            print_r($this->testData);
            $this->testData = [];
            echo "\n\n";
        }
    }

    protected function checkDefaultResponse(ApiTester $I, int $alternativeCode = 0) {
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["code" => $alternativeCode]);

    }
    public function createGroup(ApiTester $I){
        $charset = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $rand_str = '';
        $desired_length = 10;
        while (strlen($rand_str) < $desired_length)
            $rand_str .= substr(str_shuffle($charset), 0, 1);
        $I->sendPost('/v1/groups', json_encode([
            "name" => $rand_str,
        ]));
    }


}