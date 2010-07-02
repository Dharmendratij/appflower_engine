<?php

/**
 * A filter to allow authentication by an API key.
 * Put the filter before the security filter.
 *
 * Request parameter "af_apikey" is checked for the API key.
 * Each user has her own API key.
 * The key could be regenerated by changing the user password.
 */
class afApikeySecurityFilter extends sfFilter {
    public function execute($filterChain) {
        $context = $this->getContext();
        if ($this->isFirstCall() && !$context->getUser()->isAuthenticated()) {
            $apikey = $context->getRequest()->getParameter('af_apikey');
            if ($apikey) {
                $guardUser = self::getApiUser($apikey);
                if ($guardUser !== null) {
                    $context->getUser()->signIn($guardUser);
                } else {
                    echo json_encode(array('success'=>false, 'message'=>'Wrong API key.'));
                    exit;
                }
            }
        }

        $filterChain->execute();
    }

    /**
     * Returns an active sfGuardUser for a valid key
     * or null.
     */
    private static function getApiUser($apikey) {
        $parts = explode(afAuthenticDatamaker::MSG_SEPARATOR, $apikey, 2);
        if(count($parts) !== 2) {
            return null;
        }

        list($hmac, $username) = $parts;
        $guardUser = sfGuardUserPeer::retrieveByUsername($username);
        if ($guardUser === null) {
            return null;
        }

        $extraKey = $guardUser->getPassword();
        $username = afAuthenticDatamaker::plainDecode($apikey, $extraKey);
        if ($username === null) {
            return null;
        }

        return $guardUser;
    }

    public static function isCurrentUserKey($apikey) {
        $user = sfContext::getInstance()->getUser();
        if (!$user->isAuthenticated()) {
            return false;
        }

        $keyGuardUser = self::getApiUser($apikey);
        if ($keyGuardUser === null) {
            return false;
        }

        return ($keyGuardUser->getUsername() ===
            $user->getGuardUser()->getUsername());
    }

    /**
     * Returns API key usable for the given user.
     * The API key consists of "hmac,username".
     */
    public static function getApikey($guardUser) {
        $extraKey = $guardUser->getPassword();
        return afAuthenticDatamaker::plainEncode($guardUser->getUsername(),
            $extraKey);
    }
}

