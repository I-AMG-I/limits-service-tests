<?php

namespace App\Tests\api\LS;

use App\Tests\api\CardsBase;
use ApiTester;
use function PHPUnit\Framework\assertEquals;

/** Tests if user is able to create a group with existing name
 * @group instanceList
 */
class CreateGroupNSCest extends CardsBase
{



    public function existingGroup(ApiTester $I)
    {


        $params = [
            "name" => "testGeorgi"

        ];

        // test if user is able to load money with 0 amount
        $I->sendPost("/v1/groups", $params);
        $this->checkDefaultResponse($I, 7001);
        $I->seeResponseMatchesJsonType([

                'code' => 'integer',
                'message' => 'string'


        ]);
        $details = $I->grabDataFromResponseByJsonPath('$.message.')[0]; //0 is the first element
        assertEquals($details, 'services.limit.group_already_exists');
        print_r($details);



    }




/** Tests if user is able to create a group with more than 255 char
 * @group group255
 */





    public function invalidGroup(ApiTester $I)
    {


        $params = [
            "name" => "georgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTestgeorgiTest"

        ];

        // test if user is able to load money with 0 amount
        $I->sendPost("/v1/groups", $params);
        $this->checkDefaultResponse($I, 11001);
        $I->seeResponseMatchesJsonType([

            'code' => 'integer',
            'message' => 'string'


        ]);
        $details = $I->grabDataFromResponseByJsonPath('$.errors.name')[0]; //0 is the first element
        assertEquals($details, 'This value is not valid.');
        print_r($details);



    }


}