<?php

namespace Lw\Contentory\Agent\UserProfil\Specification;

use \Lw\Contentory\Agent\UserProfil\Repository\Repository as Repository;
use \Lw\Library\DTO as DTO;
use \Lw\Library\Specification\isValid as BaseIsValid;

class IsValid extends BaseIsValid
{

    public function __construct()
    {
        $this->Repository = new Repository();
    }

    static public function getInstance()
    {
        return new IsValid();
    }

    public function setRequestType($Type)
    {
        $this->Type = $Type;
    }

    public function isSatisfiedBy(DTO $dto)
    {
        $this->resetErrors();

        $auth = \lw_registry::getInstance()->getEntry("auth");

        $version = $dto->getValueByKey("lw_version");
        if ($version < $this->Repository->getVersion($auth->getUserdata("id"))) {
            $this->addError('version', 1);
        }

        $name = trim($dto->getValueByKey("name"));
        if (strlen($name) < 3 || strlen($name) > 255) {
            $this->addError('name', "length");
        }
        if ($auth->getUserdata("name") != $name && $this->Repository->isNameExisting($name)) {
            $this->addError('name', "existing");
        }
        if ($this->testRegex($name, '/[^[:alpha:]0-9äÄöÖüÜ\ \-_\.]/i')) {
            $this->addError('name', "allowedLetters");
        }

        $pass = trim($dto->getValueByKey("password"));
        if (strlen($pass) > 0 && strlen($pass) < 5) {
            $this->addError('password', "length");
        }

        $passRepeat = trim($dto->getValueByKey("password_wdhl"));
        if ($pass != $passRepeat) {
            $this->addError('password_wdhl', "identical");
        }

        $firstname = trim($dto->getValueByKey("firstname"));
        if (strlen($firstname) > 255) {
            $this->addError('firstname', "length");
        }

        $lastname = trim($dto->getValueByKey("lastname"));
        if (strlen($lastname) > 255) {
            $this->addError('lastname', "length");
        }

        $email = trim($dto->getValueByKey("email"));
        if (strlen($email) > 0 && filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            $this->addError("email", "syntax");
        }

        for ($i = 1; $i <= 5; $i++) {
            $shortcut =trim($dto->getValueByKey("shortcut" . $i));
            if (!ctype_digit($shortcut) && !empty($shortcut)) {
                $this->addError("shortcut" . $i, "nonDigit");
            }
        }

        if ($this->hasErrors()) {
            return false;
        }
        return true;
    }

}
