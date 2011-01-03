<?php
class UserRegister extends AbstractCall {
    public function __construct($email, $phone, $firstname, $lastname, $address, $city, $country, $postcode) {
        $this->method = 'registerUser';
        $this->parameters = array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'address' => $address,
            'city' => $city,
            'state' => 'state',
            'countryId' => $country,
            'zip' => $postcode,
            'phone' => $phone,
            'fax' => '032432432',
            'subNews' => 0,
            'flashFlag' => 0,
            'siteId' => self::SITE
        );
    }
}
?>