<?php

namespace App\Tests\api\LS;

use App\Tests\api\CardsBase;
use ApiTester;
use phpDocumentor\Reflection\Types\Boolean;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertJsonStringEqualsJsonString;
use function PHPUnit\Framework\assertNotNull;

/** Tests if user is able to update group by token group
 * @group instance
 */
class UpdateGroupCest extends CardsBase
{


    public function updateGroup(ApiTester $I)
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
        $I->sendPut("/v1/groups/$this->testGROUPToken", json_encode([
            "name" => $rand_str
        ]));

        $this->checkDefaultResponse($I);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        //dd($details);


//        var_dump($I->grabResponse());
    }

    public function updateGroupExistingNameNS(ApiTester $I)
    {

        $this->ensureGroup($I);

        $params = [
            "name" => "testGeorgi"

        ];

        // test if user is able to update group with existing limit group
        $I->sendPut("/v1/groups/$this->testGROUPToken", $params);
        $this->checkDefaultResponse($I, 7001);
        $I->seeResponseMatchesJsonType([

            'code' => 'integer',
            'message' => 'string'


        ]);
        $details = $I->grabDataFromResponseByJsonPath('$.message.')[0]; //0 is the first element
        assertEquals($details, 'services.limit.group_already_exists');
        assertNotNull($details);
        print_r($details);
//        dd($details);


    }

    public function updateGroupUnexistingLimitGroupNS(ApiTester $I)
    {

        $this->ensureGroup($I);

        $params = [
            "name" => "testGeorgi"

        ];

        // test if user is able to update group with unexisting limit group
        $I->sendPut("/v1/groups/123456789", $params);
        $this->checkDefaultResponse($I, 7002);
        $I->seeResponseMatchesJsonType([

            'code' => 'integer',
            'message' => 'string'


        ]);
        $details = $I->grabDataFromResponseByJsonPath('$.message.')[0]; //0 is the first element
        assertEquals($details, 'services.limit.group_not_found');
        print_r($details);
//        dd($details);


    }

}