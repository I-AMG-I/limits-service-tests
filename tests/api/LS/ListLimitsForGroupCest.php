<?php

namespace App\Tests\api\LS;

use App\Tests\api\CardsBase;
use ApiTester;
use function PHPUnit\Framework\assertEquals;

/** Tests if user is able to have a list of limits of group
 * @group instanceList
 */
class ListLimitsForGroupCest extends CardsBase
{

    /**
     * @group list
     */
    public function listGroups(ApiTester $I)
    {
        //create document
        $this->createLimit($I);


        // this should be successful
        $I->sendGet("/v1/groups/$this->testGROUPToken/limits/list/1/1");
        $this->checkDefaultResponse($I);
        $I->seeResponseMatchesJsonType([
            'data' => [
                "items" => [[
                    "token" => "string",
                    "operation" => "string",
                ]],
                "total_items" => 'integer'
            ]]);


    }

    /** Tests if user is able to have a list of two limits of group(check "total_items" = "2")
     * @group LimitsListCheck
     */
    public function listGroupsItems(ApiTester $I)
    {
        //create document
        $this->createLimit($I);



        // this should be successful
        $I->sendGet("/v1/groups/$this->testGROUPToken/limits/list/1/1");
        $this->checkDefaultResponse($I);
        $I->seeResponseMatchesJsonType([
            'data' => [
                "items" => [[
                    "token" => "string",
                    "operation" => "string",
                ]],
                "total_items" => 'integer'
            ]]);

        $details = $I->grabDataFromResponseByJsonPath('$.data.total_items')[0]; //0 is the first element
        assertEquals($details, 2);
        print_r($details);


    }



}