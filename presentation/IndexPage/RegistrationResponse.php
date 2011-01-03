<?
require_once PATH_PRESENTATION . 'common/ResponseBase.php';

class RegistrationResponse extends  ResponseBase {

    public function __construct() {
        parent::__construct('registration.tpl');

        parent::declareVars(array(
            'email',
            'phone',
            'firstname',
            'lastname',
            'address',
            'city',
            'country',
            'postcode',
            'registrationError'
            ));

    }
    
    public function setEmail($email) {
        $this->set('email', $email);
    }
    
    public function setPhone($phone) {
        $this->set('phone', $phone);
    }
    
    public function setFirstname($firstname) {
        $this->set('firstname', $firstname);
    }

    public function setLastname($lastname) {
        $this->set('lastname', $lastname);
    }

    public function setAddress($address) {
        $this->set('address', $address);
    }

    public function setCity($city) {
        $this->set('city', $city);
    }

    public function setCountry($country) {
        $this->set('country', $country);
    }

    public function setPostcode($postcode) {
        $this->set('postcode', $postcode);
    }

    public function setError($registrationError) {
        $this->set('registrationError', $registrationError);
    }
    
}

?>
