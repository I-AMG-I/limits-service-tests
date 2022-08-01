<?php

namespace App\Tests\api\LS;

use App\Tests\api\CardsBase;
use ApiTester;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;

/** Tests if user is able to update limit. Only the provided fields are updated, the rest are not
 * @group updateLimit
 */
class UpdateLimitFieldsCest extends CardsBase
{

    /**
     * @group updateLimits
     */
    public function updateLimits(ApiTester $I)
    {
        //create document
        $this->createLimit($I);

        // All fields are optional
        $params = [
            "operation" => "testOperation"

        ];

        // test if user is able to update group with existing limit group
        $I->sendPatch("/v1/limits/$this->testLIMITToken", $params);
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
        $I->sendPatch("/v1/limits/12345678", $params);
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

    /** Test if user is able to update limit фиелдс with params when already existing in another limit
     * @group listLimitsFieldsExisting
     */
    public function listLimitsfieldsNS2(ApiTester $I)
    {
        //create limit
        $this->createLimit($I);

        // this should be successful
        $params = [
            "operation" => "testGogo"

        ];

        // test if user is able to update limit
        $I->sendPatch("/v1/limits/$this->testLIMITToken", $params);
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
        $I->sendPatch("/v1/limits/$this->testLIMITToken", $params);
        $this->checkDefaultResponse($I);



        // test if user is able to load money with 0 amount
        $I->sendPatch("/v1/limits/$this->testLIMITToken", $params);
        $this->checkDefaultResponse($I, 11001);
        $I->seeResponseMatchesJsonType([

            'code' => 'integer',
            'message' => 'string'


        ]);
        $details = $I->grabDataFromResponseByJsonPath('$.errors.name')[0]; //0 is the first element
        assertEquals($details, 'This value is not valid.');
        print_r($details);




    }


    /** Tests if user is able to patch a limit of all fields and then update only one field without changing the others
     * @group patchlimit
     */


    public function patchLimit(ApiTester $I)
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
        $I->sendPatch("/v1/limits/$this->testLIMITToken", $params);
        $this->checkDefaultResponse($I);

        // this should be successful
        $params2 = [
            "operation" => "test3",
            "currency" => "GBP",
            "single_operation_limit" => 2,
            "daily_limit" => 2,
            "daily_operation_count" => 2,
            "weekly_limit" => 2,
            "weekly_operation_count" => 2,
            "monthly_limit" => 2,
            "monthly_operation_count" => 2,
            "yearly_limit" => 2,
            "yearly_operation_count" => 2,
            "business_level" => "businesslevel",
            "kyc_business_level" => "kycbusinesslevel"
        ];


        // this should be successful
        $I->sendPatch("/v1/limits/$this->testLIMITToken", $params2);
        $this->checkDefaultResponse($I);


        // this should be unsuccessful, NEGATIVE SCENARIO FOR FIELDS
        $params3 = [
            "operation" => 1,
            "currency" => 2,
            "single_operation_limit" => "test2",
            "daily_limit" => "test2",
            "daily_operation_count" => "test2",
            "weekly_limit" => "test2",
            "weekly_operation_count" => "test2",
            "monthly_limit" => "test2",
            "monthly_operation_count" => "test2",
            "yearly_limit" => "test2",
            "yearly_operation_count" => "test2",
            "business_level" => 3,
            "kyc_business_level" => 4
        ];

        // test if user is able to load money with 0 amount
        $I->sendPatch("/v1/limits/$this->testLIMITToken", $params3);
        $this->checkDefaultResponse($I, 400);
        $details = $I->grabDataFromResponseByJsonPath('$.message')[0]; //0 is the first element
        assertEquals($details, 'services.general.bad_request');
        print_r($details);


    }

}
