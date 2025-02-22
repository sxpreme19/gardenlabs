<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use common\models\User;
use Yii;

class FirstCest
{
    public function _before(AcceptanceTester $I) {}

    public function checkoutProcess(AcceptanceTester $I)
    {
        $I->amOnPage('/frontend/web/index.php?r=site%2Flogin');
        codecept_debug($I->grabFromCurrentUrl());
        $I->fillField('#loginform-username', 'diogo');
        $I->fillField('#loginform-password', 'diogo123');
        $I->click('Login');
        //$I->see('Welcome');

        $I->amOnPage('/frontend/web/index.php?r=produto%2Findex');
        $I->see('Product Shop');
        $I->click(['link' => 'View']);

        $I->amOnPage('/frontend/web/index.php?r=produto%2Fproduct-details&id=57');
        $I->see('available');
        $I->click(['link' => 'Add to cart']);

        $I->amOnPage('/frontend/web/index.php?r=carrinhoproduto%2Findex');
        $I->see('Cart');
        $I->see('Produto');
        $I->click(['link' => 'Checkout']);

        $I->see('Billing Address');
        $I->fillField(['id' => 'fullName'], 'Diogo Silva');
        $I->fillField(['id' => 'address'], '123 Test Street, Lisbon');
        $I->fillField(['id' => 'phone'], '912345678');
        $I->fillField(['id' => 'nif'], '123456789');
        $I->click(['id' => 'paymentMethod1']);
        $I->click(['id' => 'shippingMethod1']);
        $I->click(['link' => 'Proceed to Confirm Order']);

        $I->see('Confirm Your Order');
        $I->see('Order Summary');
        $I->see('Product');
        $I->see('Subtotal');
        $I->see('Shipping Cost');
        $I->see('Grand Total');
        $I->click(['link' => 'Confirm and Pay']);

        $I->see('Invoice #');
        $I->see('Thank you for your order!');
        $I->see('Order Summary');
        $I->see('Payment Method');
        $I->see('Shipping Method');
        $I->see('Grand Total');
        $I->see('Back to Shop');

        $I->see('Name: Diogo Silva');
        $I->see('Address: 123 Test Street, Lisbon');
        $I->see('Phone: 912345678');
        $I->see('NIF: 123456789');
        $I->see('Payment Method: Credit Card');
    }
}
