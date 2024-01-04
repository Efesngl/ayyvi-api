<?php

namespace App\Http\Controllers\api\V1;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    //
    public function make_donate(Request $req)
    {
        $user = Users::where("ID", $req->input("userID"))->first();
        $cc = $req->input("cc");
        $options = new \Iyzipay\Options();
        $options->setApiKey("sandbox-dVlqiZh9nz88ev05DnBgiOtZtpUpFRMS");
        $options->setSecretKey("sandbox-OLxAz9yQGoVapGyx6VRb4viIKobjYp7r");
        $options->setBaseUrl("https://sandbox-api.iyzipay.com");
        # create request class
        // $request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
        // $request->setLocale(\Iyzipay\Model\Locale::TR);
        // $request->setPrice($req->input("donation_amount"));
        // $request->setPaidPrice($req->input("donation_amount"));
        // $request->setCurrency(\Iyzipay\Model\Currency::TL);
        // $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
        // $request->setCallbackUrl("http://localhost:");
        // $request->setEnabledInstallments(array(2, 3, 6, 9));
        $request = new \Iyzipay\Request\CreatePaymentRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setConversationId("123456789");
        $request->setPrice($req->input("donationAmount"));
        $request->setPaidPrice($req->input("donationAmount"));
        $request->setCurrency(\Iyzipay\Model\Currency::TL);
        $request->setPaymentChannel(\Iyzipay\Model\PaymentChannel::WEB);
        $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);

        $paymentCard = new \Iyzipay\Model\PaymentCard();
        $paymentCard->setCardHolderName($cc["cardHolder"]);
        $paymentCard->setCardNumber($cc["cardNumber"]);
        $paymentCard->setExpireMonth($cc["cardExp"]["m"]);
        $paymentCard->setExpireYear($cc["cardExp"]["y"]);
        $paymentCard->setCvc($cc["cardCvv"]);
        $paymentCard->setRegisterCard(0);
        $request->setPaymentCard($paymentCard);

        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId($user->ID);
        $buyer->setName($user->firstname);
        $buyer->setSurname($user->lastname);
        $buyer->setEmail($user->email);
        $buyer->setIdentityNumber("11111111111");
        $buyer->setRegistrationAddress("Şükrükaraduman caddesi no:139 daire:1");
        $buyer->setIp($req->ip());
        $buyer->setCity("İzmir");
        $buyer->setCountry("Turkey");
        $buyer->setZipCode("35160");
        $request->setBuyer($buyer);

        $shippingAddress = new \Iyzipay\Model\Address();
        $shippingAddress->setContactName($user->firstname . " " . $user->lastname);
        $shippingAddress->setCity("Izmir");
        $shippingAddress->setCountry("Turkey");
        $shippingAddress->setAddress("Şükrükaraduman caddesi no:139 daire:1");
        $shippingAddress->setZipCode("35160");
        $request->setShippingAddress($shippingAddress);

        $billingAddress = new \Iyzipay\Model\Address();
        $billingAddress->setContactName($user->firstname . " " . $user->lastname);
        $billingAddress->setCity("Izmir");
        $billingAddress->setCountry("Turkey");
        $billingAddress->setAddress("Şükrükaraduman caddesi no:139 daire:1");
        $billingAddress->setZipCode("35160");
        $request->setBillingAddress($billingAddress);

        $basketItems = array();
        $firstBasketItem = new \Iyzipay\Model\BasketItem();
        $firstBasketItem->setId("BI101");
        $firstBasketItem->setName("donation");
        $firstBasketItem->setCategory1("donation");
        $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
        $firstBasketItem->setPrice($req->input("donationAmount"));
        $basketItems[0] = $firstBasketItem;

        $request->setBasketItems($basketItems);

        # make request
        $payment = \Iyzipay\Model\Payment::create($request, $options);

        # print result
        $status = $payment->getStatus();
        if ($status == "success") {
            if (DB::table("donations")->insert([
                "user_id" => $req->input("userID"),
                "donation_amount" => $req->input("donationAmount")
            ])) {
                return response("", 201);
            }
        }
        return response("",400);
    }
    public function iyzico()
    {
        $options = new \Iyzipay\Options();
        $options->setApiKey("sandbox-dVlqiZh9nz88ev05DnBgiOtZtpUpFRMS");
        $options->setSecretKey("sandbox-OLxAz9yQGoVapGyx6VRb4viIKobjYp7r");
        $options->setBaseUrl("https://sandbox-api.iyzipay.com");

        $request = new \Iyzipay\Request\CreatePaymentRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setConversationId("123456789");
        $request->setPrice("1");
        $request->setPaidPrice("1.2");
        $request->setCurrency(\Iyzipay\Model\Currency::TL);
        $request->setInstallment(1);
        $request->setBasketId("B67832");
        $request->setPaymentChannel(\Iyzipay\Model\PaymentChannel::WEB);
        $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);

        $paymentCard = new \Iyzipay\Model\PaymentCard();
        $paymentCard->setCardHolderName("John Doe");
        $paymentCard->setCardNumber("4124111111111116");
        $paymentCard->setExpireMonth("12");
        $paymentCard->setExpireYear("2024");
        $paymentCard->setCvc("123");
        $paymentCard->setRegisterCard(0);
        $request->setPaymentCard($paymentCard);

        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId("BY789");
        $buyer->setName("John");
        $buyer->setSurname("Doe");
        $buyer->setGsmNumber("+905350000000");
        $buyer->setEmail("email@email.com");
        $buyer->setIdentityNumber("74300864791");
        $buyer->setLastLoginDate("2015-10-05 12:43:35");
        $buyer->setRegistrationDate("2013-04-21 15:12:09");
        $buyer->setRegistrationAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $buyer->setIp("85.34.78.112");
        $buyer->setCity("Istanbul");
        $buyer->setCountry("Turkey");
        $buyer->setZipCode("34732");
        $request->setBuyer($buyer);

        $shippingAddress = new \Iyzipay\Model\Address();
        $shippingAddress->setContactName("Jane Doe");
        $shippingAddress->setCity("Istanbul");
        $shippingAddress->setCountry("Turkey");
        $shippingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $shippingAddress->setZipCode("34742");
        $request->setShippingAddress($shippingAddress);

        $billingAddress = new \Iyzipay\Model\Address();
        $billingAddress->setContactName("Jane Doe");
        $billingAddress->setCity("Istanbul");
        $billingAddress->setCountry("Turkey");
        $billingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $billingAddress->setZipCode("34742");
        $request->setBillingAddress($billingAddress);

        $basketItems = array();
        $firstBasketItem = new \Iyzipay\Model\BasketItem();
        $firstBasketItem->setId("BI101");
        $firstBasketItem->setName("Binocular");
        $firstBasketItem->setCategory1("Collectibles");
        $firstBasketItem->setCategory2("Accessories");
        $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
        $firstBasketItem->setPrice("0.3");
        $basketItems[0] = $firstBasketItem;

        $secondBasketItem = new \Iyzipay\Model\BasketItem();
        $secondBasketItem->setId("BI102");
        $secondBasketItem->setName("Game code");
        $secondBasketItem->setCategory1("Game");
        $secondBasketItem->setCategory2("Online Game Items");
        $secondBasketItem->setItemType(\Iyzipay\Model\BasketItemType::VIRTUAL);
        $secondBasketItem->setPrice("0.5");
        $basketItems[1] = $secondBasketItem;

        $thirdBasketItem = new \Iyzipay\Model\BasketItem();
        $thirdBasketItem->setId("BI103");
        $thirdBasketItem->setName("Usb");
        $thirdBasketItem->setCategory1("Electronics");
        $thirdBasketItem->setCategory2("Usb / Cable");
        $thirdBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
        $thirdBasketItem->setPrice("0.2");
        $basketItems[2] = $thirdBasketItem;
        $request->setBasketItems($basketItems);

        $payment = \Iyzipay\Model\Payment::create($request, $options);
        echo "<pre>";
        print_r($payment);
    }
    public function get_donations(Request $req)
    {
        $donations = DB::table("donations")->select("donation_amount as donationAmount", "donated_at as donatedAt")->where("user_id", $req->query("user"))->get();
        return response()->json([$donations]);
    }
}
