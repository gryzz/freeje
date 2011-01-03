<?
require_once PATH_PRESENTATION . 'common/RequestBase.php';

class RegistrationRequest extends RequestBase {

    public function isFormPosted() {
        return $this->hasParameter('registration_form_posted');
    }

    public function getPhone() {
        if ($this->hasParameter('phone')) {
            return $this->getParameter('phone');
        }

        return null;
    }

    public function getEmail() {
        if ($this->hasParameter('email')) {
            return $this->getParameter('email');
        }

        return null;
    }

    public function getFirstname() {
        if ($this->hasParameter('firstname')) {
            return $this->getParameter('firstname');
        }

        return null;
    }

    public function getLastname() {
        if ($this->hasParameter('lastname')) {
            return $this->getParameter('lastname');
        }

        return null;
    }

    public function getAddress() {
        if ($this->hasParameter('address')) {
            return $this->getParameter('address');
        }

        return null;
    }

    public function getCity() {
        if ($this->hasParameter('city')) {
            return $this->getParameter('city');
        }

        return null;
    }

    public function getCountry() {
        if ($this->hasParameter('country')) {
            return $this->getParameter('country');
        }

        return null;
    }

    public function getPostcode() {
        if ($this->hasParameter('postcode')) {
            return $this->getParameter('postcode');
        }

        return null;
    }

}

?>
