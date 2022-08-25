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

    /** Test if user is able to update limit with params when already existing in another limit(should fail now, because of bug that should be fixed)
     * @group listLimitsExisting
     */
    public function listLimitsNS2(ApiTester $I)
    {
        //create limit
        $this->createLimit($I);

        // this should be successful
        $params = [
            "operation" => "testG"

        ];

        // test if user is able to update limit
        $I->sendPut("/v1/limits/$this->testLIMITToken", $params);
        $this->checkDefaultResponse($I);


        // test if user is able to update the limit again with the same values
        $I->sendPut("/v1/limits/$this->testLIMITToken", $params);
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

    /** Tests if user is able to update a limit with more than 255 char
     * @group limit255
     */


    public function invalidLimit(ApiTester $I)
    {
        //create limit
        $this->createLimit($I);

        // this should be successful
        $params = [
            "operation" => "georgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTest"

        ];

        // test if user is able to update limit
        $I->sendPut("/v1/limits/$this->testLIMITToken", $params);
        $this->checkDefaultResponse($I);


        // test if user is able to load money with 0 amount
        $I->sendPut("/v1/limits/$this->testLIMITToken", $params);
        $this->checkDefaultResponse($I, 11001);
        $I->seeResponseMatchesJsonType([

            'code' => 'integer',
            'message' => 'string'


        ]);
        $details = $I->grabDataFromResponseByJsonPath('$.errors.name')[0]; //0 is the first element
        assertEquals($details, 'This value is not valid.');
        print_r($details);


    }

    /** Tests if user is able to update a limit of all fields and then update only one field with changing the others
     * @group updateLimitOneField
     */


    public function updateLimit(ApiTester $I)
    {
        //create limit
        $this->createLimit($I);

        // this should be successful
        $params = [
            "operation" => "test2",
            "currency" => "BGN",
            "single_operation_limit" => 1,
            "daily_limit" => 1,
            "daily_operation_count" => 1,
            "weekly_limit" => 1,
            "weekly_operation_count" => 1,
            "monthly_limit" => 1,
            "monthly_operation_count" => 1,
            "yearly_limit" => 1,
            "yearly_operation_count" => 1,
            "business_level" => "1",
            "kyc_business_level" => "1"
        ];

        // test if user is able to update limit
        $I->sendPut("/v1/limits/$this->testLIMITToken", $params);
        $this->checkDefaultResponse($I);
        //list current limit to see if data is properly recorded
        $I->sendGet("/v1/limits/$this->testLIMITToken");
        $I->seeResponseMatchesJsonType([
            "data" => [
                "operation" => "string",
                "currency" => "string",
                "single_operation_limit" => 'integer',
                "daily_limit" => 'integer',
                "daily_operation_count" => 'integer',
                "weekly_limit" => 'integer',
                "weekly_operation_count" => 'integer',
                "monthly_limit" => 'integer',
                "monthly_operation_count" => 'integer',
                "yearly_limit" => 'integer',
                "yearly_operation_count" => 'integer',
                "business_level" => "string",
                "kyc_business_level" => "string",

            ]

        ]);


        // this should be successful
        $params2 = [
            "operation" => "operations",
        ];


        // this should be successful
        $I->sendPut("/v1/limits/$this->testLIMITToken", $params2);
        $this->checkDefaultResponse($I);
        //list current limit to see if data is properly recorded
        $I->sendGet("/v1/limits/$this->testLIMITToken");
        //see if only operation is changed and other should be null
        $I->dontSeeResponseMatchesJsonType([

            "data" => [
               // "operation" => 'string',
                  "currency" => 'string',
                "single_operation_limit" => 'integer',
                "daily_limit" => 'integer',
                "daily_operation_count" => 'integer',
                "weekly_limit" => 'integer',
                "weekly_operation_count" => 'integer',
                "monthly_limit" => 'integer',
                "monthly_operation_count" => 'integer',
                "yearly_limit" => 'integer',
                "yearly_operation_count" => 'integer',
                "business_level" => "string",
                "kyc_business_level" => "string"

            ]


        ]);


    }

}

