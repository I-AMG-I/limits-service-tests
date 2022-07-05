<?php

namespace App\Tests\api\LS;

use App\Tests\api\CardsBase;
use ApiTester;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;

/** Check if user is able to delete a limit entry by token.
 * @group updateLimit
 */
class DeleteLimitCest extends CardsBase
{

    public function deleteLimits(ApiTester $I)
    {
        //create limit
        $this->createLimit($I);


        // test if user is able to update group with existing limit group
        $I->sendDelete("/v1/limits/$this->testLIMITToken");
        $this->checkDefaultResponse($I);


    }

    /** Test if user is able to delete already deleted limit
     * @group listLimits
     */
    public function deleteLimitsNS(ApiTester $I)
    {
        //create limit
        $this->createLimit($I, true);


        // this should be successful
        $I->sendDelete("/v1/limits/$this->testLIMITToken");
        $this->checkDefaultResponse($I);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        // delete already deleted limit
        $I->sendDelete("/v1/limits/$this->testLIMITToken");
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

    /** Test if user is able to delete unexisting limit
     * @group listLimits
     */
    public function deleteLimitsNS2(ApiTester $I)
    {
        //create limit
        $this->createLimit($I, true);


        // delete unexisting limit
        $I->sendDelete("/v1/limits/123456789");
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

}