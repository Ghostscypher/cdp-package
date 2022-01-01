<?php


use Illuminate\Auth\Access\AuthorizationException;

class InvalidClientCredentialsException extends AuthorizationException
{
    /**
     * Create a new InvalidClientCredentialsException for different client credentials.
     *
     * @return static
     */
    public static function different()
    {
        return new static('The provided credentials for the request is different from the client credentials in the system.');
    }
}
