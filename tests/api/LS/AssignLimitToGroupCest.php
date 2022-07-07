<?php

namespace App\Tests\api\LS;

use App\Tests\api\CardsBase;
use ApiTester;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;

/** Tests if user is able to assign a limit's group association
 * @group assignLimit
 */
class AssignLimitToGroupCest extends CardsBase
{
    /** Tests if user is able to assign a limit's group association
     * @group assignLimit2
     */
    public function assignLimit(ApiTester $I)
    {
        //create limit
        $this->createLimit($I);
        $this->createLimit2($I);


        // this should be successful
        $params = [
            "group" => $this->testGROUPToken2

        ];

        // test if user is able to update group with existing limit group
        $I->sendPut("/v1/limits/$this->testLIMITToken/group", $params);
        $this->checkDefaultResponse($I);




    }

    /** Test if user is able to assign unexisting limit
     * @group assignUnexsitingLimits
     */
    public function assignLimitsNS(ApiTester $I)
    {
        //create limit
        $this->createLimit($I);

        $params = [
            "group" => $this->testGROUPToken

        ];


        // this should be successful
        $I->sendPut("/v1/limits/123456789/group", $params);
        $this->checkDefaultResponse($I, 7003);
        $I->seeResponseMatchesJsonType([

            'code' => 'integer',
            'message' => 'string'


        ]);
        $details = $I->grabDataFromResponseByJsonPath('$.message.')[0]; //0 is the first element
        assertEquals($details, 'services.limit.limit_not_found');
        assertNotNull($details);
        print_r($details);


    }

    /** Test if user is able to assign already assigned limit to the group
     * @group assignExistingLimit
     */
    public function assignLimitsNS2(ApiTester $I)
    {
        //create limit
        $this->createLimit($I, true);

        $params = [
            "group" => $this->testGROUPToken

        ];


        // try to assign already existing limit
        $I->sendPut("/v1/limits/$this->testLIMITToken/group", $params);
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

}