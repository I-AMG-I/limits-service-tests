<?php

namespace App\Tests\api\LS;

use App\Tests\api\CardsBase;
use ApiTester;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;

/** Tests if user is able to get limit details by limit token
 * @group instanceList
 */
class GetLimitCest extends CardsBase
{

    /**
     * @group listLimits
     */
    public function listLimits(ApiTester $I)
    {
        //create document
        $this->createLimit($I);

        // this should be successful
        $I->sendGet("/v1/limits/$this->testLIMITToken");
        $this->checkDefaultResponse($I);
        $I->seeResponseMatchesJsonType([
            'data' => [

                    "operation" => "string",

                ],

            ]);


    }

    /** Test if user is able to list unexisting limit
     * @group listLimits
     */
    public function listLimitsNS(ApiTester $I)
    {
        //create limit
        $this->createLimit($I);



        // this should be successful
        $I->sendGet("/v1/limits/12345678");
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

    /** Test if user is able to list already deleted limit
     * @group listLimits
     */
    public function listLimitsNS2(ApiTester $I)
    {
        //create limit
        $this->createLimit($I, true);


        //successfully delete created limit
        $I->sendDelete("/v1/limits/$this->testLIMITToken");
        $this->checkDefaultResponse($I);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();

        // try to get already deleted limit
        $I->sendGet("/v1/limits/$this->testLIMITToken");
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