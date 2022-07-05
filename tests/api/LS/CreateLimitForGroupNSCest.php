<?php

namespace App\Tests\api\LS;

use App\Tests\api\CardsBase;
use ApiTester;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;


class CreateLimitForGroupNSCest extends CardsBase
{


    /** Tests if user is able to create a new limit entry for specified group of limits with existing limit(Negative scenarios)
     * @group limitsNS
     */
    public function existingLimit(ApiTester $I)
    {
        //create group
        $this->ensureGroup($I);
        $params = [
            "operation" => "testOperation"

        ];

        //this should be successful
        $I->sendPost("/v1/groups/$this->testGROUPToken/limits", $params);
        $I->sendPost("/v1/groups/$this->testGROUPToken/limits", $params);
        $this->checkDefaultResponse($I, 7005);
        $I->seeResponseMatchesJsonType([

            'code' => 'integer',
            'message' => 'string'


        ]);
        $details = $I->grabDataFromResponseByJsonPath('$.message.')[0]; //0 is the first element
        assertEquals($details, 'services.limit.limit_already_exists');
        assertNotNull($details);
        print_r($details);

    }

    /** Tests if user is able to create a new limit entry for specified group of limits with unexisting group(Negative scenarios)
     * @group limitsNS2
     */
    public function unexistingGroup(ApiTester $I)
    {
        //create group
        $this->ensureGroup($I);
        $params = [
            "operation" => "testOperation"

        ];

        //this should be successful
        $I->sendPost("/v1/groups/123456789/limits", $params);
        $this->checkDefaultResponse($I, 7002);
        $I->seeResponseMatchesJsonType([

            'code' => 'integer',
            'message' => 'string'


        ]);
        $details = $I->grabDataFromResponseByJsonPath('$.message.')[0]; //0 is the first element
        assertEquals($details, 'services.limit.group_not_found');
        assertNotNull($details);
        print_r($details);

    }

    /** Tests if user is able to create a new limit entry for specified group of limits with deleted group(Negative scenarios)
     * @group limitsNS2
     */
    public function deletedGroup(ApiTester $I)
    {
        //create group
        $this->ensureGroup($I);
        //this should be successful
        $I->sendDelete("/v1/groups/$this->testGROUPToken");
        $this->checkDefaultResponse($I);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $params = [
            "operation" => "testOperation"

        ];

        //this should be successful
        $I->sendPost("/v1/groups/123456789/limits", $params);
        $this->checkDefaultResponse($I, 7002);
        $I->seeResponseMatchesJsonType([

            'code' => 'integer',
            'message' => 'string'


        ]);
        $details = $I->grabDataFromResponseByJsonPath('$.message.')[0]; //0 is the first element
        assertEquals($details, 'services.limit.group_not_found');
        assertNotNull($details);
        print_r($details);

    }

}