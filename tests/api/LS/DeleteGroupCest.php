<?php

namespace App\Tests\api\LS;

use App\Tests\api\CardsBase;
use ApiTester;
use phpDocumentor\Reflection\Types\Boolean;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertJsonStringEqualsJsonString;
use function PHPUnit\Framework\assertNotNull;

/** Tests if user is able to delete group by token group
 * @group delete
 */
class DeleteGroupCest extends CardsBase
{


    public function DeleteGroup(ApiTester $I)
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
        $I->sendDelete("/v1/groups/$this->testGROUPToken");
        $this->checkDefaultResponse($I);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        //dd($details);

        // Test if user is able to delete group when already deleted
        $I->sendDelete("/v1/groups/$this->testGROUPToken");
        $this->checkDefaultResponse($I, 7002);
        $I->seeResponseMatchesJsonType([

            'code' => 'integer',
            'message' => 'string'


        ]);
        $details = $I->grabDataFromResponseByJsonPath('$.message.')[0]; //0 is the first element
        assertEquals($details, 'services.limit.group_not_found');
        assertNotNull($details);
        print_r($details);


//        var_dump($I->grabResponse());
    }



}