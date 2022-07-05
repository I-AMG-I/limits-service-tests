<?php

namespace App\Tests\api\LS;

use App\Tests\api\CardsBase;
use ApiTester;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;

/** Tests if user is able to update limit. All fields are updated, even if empty
 * @group updateLimit
 */
class UpdateLimitCest extends CardsBase
{

    /**
     * @group updateLimits
     */
    public function updateLimits(ApiTester $I)
    {
        //create document
        $this->createLimit($I);

        // this should be successful
        $params = [
            "operation" => "testOperation"

        ];

        // test if user is able to update group with existing limit group
        $I->sendPut("/v1/limits/$this->testLIMITToken", $params);
        $this->checkDefaultResponse($I);


    }

    /** Test if user is able to update unexisting limit
     * @group listLimits
     */
    public function listLimitsNS(ApiTester $I)
    {
        //create document
        $this->createLimit($I);

        // this should be successful
        $params = [
            "operation" => "testOperation"

        ];

        // test if user is able to update limit with unexisting limit group
        $I->sendPut("/v1/limits/12345678", $params);
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