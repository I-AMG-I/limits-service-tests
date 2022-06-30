<?php

namespace App\Tests\api\LS;

use App\Tests\api\CardsBase;
use ApiTester;
use function PHPUnit\Framework\assertEquals;

/** Tests if user is able to have a list of group
 * @group instanceList
 */
class ListGroupsCest extends CardsBase
{

    /**
     * @group list
     */
    public function listGroups(ApiTester $I)
    {
        //create document
        $this->ensureGroup($I);


        // this should be successful
        $I->sendGet("/v1/groups/1/1");
        $this->checkDefaultResponse($I);
        $I->seeResponseMatchesJsonType([
            'data' => [
                "items" => [[
                "token" => "string",
                "name" => "string"
                ]],
                "total_items" => 'integer'
            ]]);


    }


}