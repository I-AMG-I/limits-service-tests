<?php

namespace App\Tests\api\LS;

use App\Tests\api\CardsBase;
use ApiTester;
use phpDocumentor\Reflection\Types\Boolean;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertJsonStringEqualsJsonString;
use function PHPUnit\Framework\assertNotNull;

/** Tests if user is able to associate group to instance and/or merchant or user
 * @group associate
 */
class AssociateGroupCardinalCest extends CardsBase
{


    public function associateGroupInstance(ApiTester $I)
    {
        //create group
        $this->ensureGroup($I);

        //create random string for unique name to be updated every time
        $charset = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $rand_str = '';
        $desired_length = 10;
        while (strlen($rand_str) < $desired_length)
            $rand_str .= substr(str_shuffle($charset), 0, 1);


        //this should be successful
        $I->sendPost("/v1/groups/$this->testGROUPToken/associate", json_encode([
            "instance" => $rand_str
        ]));

        $this->checkDefaultResponse($I);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        //dd($details);


//        var_dump($I->grabResponse());
    }

    public function associateGroupInstanceAndMerchant(ApiTester $I)
    {
        //create group
        $this->ensureGroup($I);

        //create random string for unique name to be updated every time
        $charset = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $rand_str = '';
        $rand_str2 = '';
        $desired_length = 10;
        while (strlen($rand_str) < $desired_length)
            $rand_str .= substr(str_shuffle($charset), 0, 1);
        while (strlen($rand_str2) < $desired_length)
            $rand_str2 .= substr(str_shuffle($charset), 0, 1);


        //this should be successful
        $I->sendPost("/v1/groups/$this->testGROUPToken/associate", json_encode([
            "instance" => $rand_str,
            "merchant" => $rand_str2
        ]));

        $this->checkDefaultResponse($I);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        //dd($details);


//        var_dump($I->grabResponse());
    }

    public function associateGroupInstanceAndUser(ApiTester $I)
    {
        //create group
        $this->ensureGroup($I);

        //create random string for unique name to be updated every time
        $charset = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $rand_str = '';
        $rand_str2 = '';
        $desired_length = 10;
        while (strlen($rand_str) < $desired_length)
            $rand_str .= substr(str_shuffle($charset), 0, 1);
        while (strlen($rand_str2) < $desired_length)
            $rand_str2 .= substr(str_shuffle($charset), 0, 1);


        //this should be successful
        $I->sendPost("/v1/groups/$this->testGROUPToken/associate", json_encode([
            "instance" => $rand_str,
            "user" => $rand_str2
        ]));

        $this->checkDefaultResponse($I);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        //dd($details);


//        var_dump($I->grabResponse());
    }

    public function associateGroupInstanceAndUserAndMerchant(ApiTester $I)
    {
        //create group
        $this->ensureGroup($I);

        //create random string for unique name to be updated every time
        $charset = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $rand_str = '';
        $rand_str2 = '';
        $rand_str3 = '';
        $desired_length = 10;
        while (strlen($rand_str) < $desired_length)
            $rand_str .= substr(str_shuffle($charset), 0, 1);
        while (strlen($rand_str2) < $desired_length)
            $rand_str2 .= substr(str_shuffle($charset), 0, 1);
        while (strlen($rand_str3) < $desired_length)
            $rand_str3 .= substr(str_shuffle($charset), 0, 1);


        //this should be successful
        $I->sendPost("/v1/groups/$this->testGROUPToken/associate", json_encode([
            "instance" => $rand_str,
            "user" => $rand_str2,
            "merchant" => $rand_str3
        ]));

        $this->checkDefaultResponse($I);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        //dd($details);


//        var_dump($I->grabResponse());
    }

    public function associateGroupWithoutInstanceNS(ApiTester $I)
    {
        //create group
        $this->ensureGroup($I);

        //create random string for unique name to be updated every time
        $charset = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $rand_str = '';
        $desired_length = 10;
        while (strlen($rand_str) < $desired_length)
            $rand_str .= substr(str_shuffle($charset), 0, 1);


        //this should be successful
        //try to associate group without instance field
        $I->sendPost("/v1/groups/$this->testGROUPToken/associate");

        $this->checkDefaultResponse($I, 11001);
        $I->seeResponseIsJson();
        //instance field is required
        $I->seeResponseMatchesJsonType([

            'code' => 'integer',
            'message' => 'string',
            'errors' =>
                [
                    'instance' => 'string'
                ]


        ]);
        //dd($details);


//        var_dump($I->grabResponse());
    }

    public function associateGroupWithUnexistingLimitGroupNS(ApiTester $I)
    {
        //create group
        $this->ensureGroup($I);

        $params = [
            "instance" => "testGeorgi"

        ];

        //this should be successful
        $I->sendPost("/v1/groups/$this->testGROUPToken/associate",$params);
        //try to associate the limit again to the same group
        $I->sendPost("/v1/groups/$this->testGROUPToken/associate",$params);

        $this->checkDefaultResponse($I, 7006);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        //dd($details);


//        var_dump($I->grabResponse());
        //dd($details);
        $details = $I->grabDataFromResponseByJsonPath('$.message.')[0]; //0 is the first element
        assertEquals($details, 'services.limit.association_already_exists');
        print_r($details);

//        var_dump($I->grabResponse());
    }

//    public function associateGroupWithDeletedLimitGroupNS(ApiTester $I)
//    {
//        //create group
//        $this->ensureGroup($I);
//        //this should be successful
//        $I->sendDelete("/v1/groups/$this->testGROUPToken");
//        $this->checkDefaultResponse($I);
//        $I->seeResponseCodeIsSuccessful();
//        $I->seeResponseIsJson();
//
//
//        $params = [
//            "instance" => "testGeorgi"
//
//        ];
//
//        //this should be successful
//        //try to associate group without instance field
//        $I->sendPost("/v1/groups/$this->testGROUPToken/associate", $params);
//
//        $this->checkDefaultResponse($I, 7002);
//        $I->seeResponseIsJson();
//        //instance field is required
//        $I->seeResponseMatchesJsonType([
//
//            'code' => 'integer',
//            'message' => 'string',
//
//
//        ]);
//        //dd($details);
//        $details = $I->grabDataFromResponseByJsonPath('$.message.')[0]; //0 is the first element
//        assertEquals($details, 'services.limit.group_not_found');
//        print_r($details);
//
//    }
}