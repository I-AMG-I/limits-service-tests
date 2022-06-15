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

}