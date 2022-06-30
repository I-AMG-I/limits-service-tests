<?php

namespace App\Tests\api;
use ApiTester;
use App\Tests\BasicTest;
//require_once 'vendor/autoload.php';
//$faker = Faker\Factory::create();
//$username = $faker->name;
//echo "$username";

//require_once 'vendor/autoload.php';
//$faker = Faker\Factory::create();
//
//$username = $faker->name;
//echo "$username";
/**
 * Cards base class
 */
class CardsBase extends BasicTest

{

//    protected ?string $testInstanceToken = null;
    protected ?string $testGROUPToken = null;




//sets random string every time
    protected function ensureGroup(ApiTester $I)
    {
        $charset = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $rand_str = '';
        $desired_length = 10;
        while (strlen($rand_str) < $desired_length)
            $rand_str .= substr(str_shuffle($charset), 0, 1);
        $I->sendPost('/v1/groups', json_encode([
            "name" => $rand_str,
        ]));

        $this->checkDefaultResponse($I);
// saved for later
        $this->testGROUPToken = $I->grabDataFromResponseByJsonPath('$.data.token')[0];
        //0 is the first element
//        $this->testInstanceToken = $I->grabDataFromResponseByJsonPath('$.data.token')[0];//0 is the first element
//        return $this->testInstanceToken;

    }

//    /**
//     * Generic test data
//     * @var array
//     */
//
//    protected array $instanceData = [
//
//
//        "name" => "$username", // required
//	    "document_type" => "1", // required
//
//    ];
//
//
//
//    /**
//     * Helper method to ensure document is created before a test
//     *
//     * @param $I ApiTester
//     * @return string|null
//     */
//    //create document and force create second document
//    public function ensureInstance(ApiTester $I, $forceRecreate = false): ?string
//    {
//        if ($this->testDataToken != null && $forceRecreate == false) {
//            return $this->testDataToken;
//
//        }
//        return $this->testDataToken;
//
//
//
//
//        $I->sendPost("/v1/instances", $this->instanceData);
//        $this->checkDefaultResponse($I);
//
//        // saved for later
//        $this->testDataToken = $I->grabDataFromResponseByJsonPath('$.data.id')[0];
//        //0 is the first element
//        $this->testInstanceToken = $I->grabDataFromResponseByJsonPath('$.data.token')[0];//0 is the first element
//
//
//        return $this->testInstanceToken;
//
//
//    }


}

