<?php

namespace App\Http\Middleware;

use Illuminate\Auth\GenericUser;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\ValidationData;

class JwtGuard implements Guard
{
    use GuardHelpers;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Create a new authentication guard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        // If we've already retrieved the user for the current request we can just
        // return it back immediately. We do not want to fetch the user data on
        // every call to this method because that would be tremendously slow.
        if (! is_null($this->user)) {
            return $this->user;
        }

        $user = null;

        $jwt = $this->request->bearerToken();

        if (! empty($jwt)) {
            try {
                // Attempt to parse and validate the JWT
                $token = (new Parser())->parse($jwt);
                try {
                    if ($token->verify(new Sha256(), config('pihome.jwt_key')) === false) {
                        throw new \Exception('Access token could not be verified');
                    }
                } catch (\BadMethodCallException $exception) {
                    throw new \Exception('Access token is not signed', null, $exception);
                }

                // Ensure access token hasn't expired
                $data = new ValidationData();
                $data->setCurrentTime(\time());

                if ($token->validate($data) === false) {
                    throw new \Exception('Access token is invalid');
                }
            } catch (\InvalidArgumentException $exception) {
                // JWT couldn't be parsed so return the request as is
                throw new \Exception($exception->getMessage(), null, $exception);
            } catch (\RuntimeException $exception) {
                // JWT couldn't be parsed so return the request as is
                throw new \Exception('Error while decoding to JSON', null, $exception);
            }

            $data = $token->getClaim('data');

            if($data && isset($data->user) && $data->user){
                $user = new GenericUser(json_decode(json_encode($data->user), true));

            } else {
                throw new \Exception('Missing user data');
            }
        }

        return $this->user = $user;
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        return false;
    }
}
