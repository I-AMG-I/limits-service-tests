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

  protected ?string $testLIMITToken = null;
    protected ?string $testGROUPToken = null;





//sets random string every time
    protected function ensureGroup(ApiTester $I)
    {
        $charset = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $rand_str = '';
        $desired_length = 10;
        while (strlen($rand_str) < $desired_length)
            $rand_str .= substr(str_shuffle($charset), 0, 1);

//create random group every time
        $I->sendPost('/v1/groups', json_encode([
            "name" => $rand_str,
        ]));

        $this->checkDefaultResponse($I);
// saved for later
        $this->testGROUPToken = $I->grabDataFromResponseByJsonPath('$.data.token')[0];
        //0 is the first element
//        $this->testInstanceToken = $I->grabDataFromResponseByJsonPath('$.data.token')[0];//0 is the first element
//        return $this->testInstanceToken;

        /** Create second group with different parameters to be used in assign limit
         * Cards base class
         */
    }
    protected ?string $testGROUPToken2 = null;
    protected ?string $testLIMITToken2 = null;
    protected function ensureGroup2(ApiTester $I)
    {
        $charset = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $rand_str = '';
        $desired_length = 10;
        while (strlen($rand_str) < $desired_length)
            $rand_str .= substr(str_shuffle($charset), 0, 1);

//create random group every time
        $I->sendPost('/v1/groups', json_encode([
            "name" => $rand_str,
        ]));

        $this->checkDefaultResponse($I);
// saved for later
        $this->testGROUPToken2 = $I->grabDataFromResponseByJsonPath('$.data.token')[0];
        //0 is the first element
//        $this->testInstanceToken = $I->grabDataFromResponseByJsonPath('$.data.token')[0];//0 is the first element
//        return $this->testInstanceToken;


    }



    /** Tests if user is able to create a new limit entry for specified group of limits
     * @group liimts
     */
    protected function createLimit(ApiTester $I, $forceRecreate = false): ?string
    {
        if ($this->testLIMITToken != null && !$forceRecreate) {
            return $this->testLIMITToken;

        }
        //create group
        $this->ensureGroup($I);

        //create random string for unique name to be created every time
        $charset = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $rand_str = '';
        $rand_str2 = '';
        $desired_length = 10;
        while (strlen($rand_str) < $desired_length)
            $rand_str .= substr(str_shuffle($charset), 0, 1);
        while (strlen($rand_str2) < $desired_length)
            $rand_str2 .= substr(str_shuffle($charset), 0, 1);

        //this should be successful
        $I->sendPost("/v1/groups/$this->testGROUPToken/limits", json_encode([
            "operation" => $rand_str
        ]));

        //create random second string for unique name to be created every time

        $I->sendPost("/v1/groups/$this->testGROUPToken/limits", json_encode([
            "operation" => $rand_str2
        ]));

        $this->checkDefaultResponse($I);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([

            'code' => 'integer',
            'data' => [
                "token" => 'string'
            ]


        ]);

// saved for later
        $this->testLIMITToken = $I->grabDataFromResponseByJsonPath('$.data.token')[0];


        return $this->testLIMITToken;
    }



        /** Tests if user is able to create a new limit entry for specified group of limits
         * @group liimts
         */
        protected function createLimit2(ApiTester $I, $forceRecreate = false): ?string
    {
        if ($this->testLIMITToken2 != null && !$forceRecreate) {
            return $this->testLIMITToken2;

        }
        //create group
        $this->ensureGroup2($I);

        //create random string for unique name to be created every time
        $charset = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $rand_str = '';
        $rand_str2 = '';
        $desired_length = 10;
        while (strlen($rand_str) < $desired_length)
            $rand_str .= substr(str_shuffle($charset), 0, 1);
        while (strlen($rand_str2) < $desired_length)
            $rand_str2 .= substr(str_shuffle($charset), 0, 1);

        //this should be successful
        $I->sendPost("/v1/groups/$this->testGROUPToken2/limits", json_encode([
            "operation" => $rand_str
        ]));

        //create random second string for unique name to be created every time

        $I->sendPost("/v1/groups/$this->testGROUPToken2/limits", json_encode([
            "operation" => $rand_str2
        ]));

        $this->checkDefaultResponse($I);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([

            'code' => 'integer',
            'data' => [
                "token" => 'string'
            ]


        ]);

// saved for later
        $this->testLIMITToken2 = $I->grabDataFromResponseByJsonPath('$.data.token')[0];


        return $this->testLIMITToken2;
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


}}

