<?php
/**
 * Copyright (c) 2018 Matthias Morin <matthias.morin@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace TangoMan\JWTBundle\Services;

use TangoMan\JWTBundle\Model\JWT;
use Firebase\JWT\JWT as Codec;

/**
 * Class JWTService
 *
 * @package TangoMan\JWTBundle\Services
 */
class JWTService
{

    /**
     * @var string
     */
    private $secret;

    /**
     * JWT constructor.
     */
    public function __construct($secret)
    {
        // Default encryption password taken from Symfony secret parameter
        $this->secret = $secret;
    }

    /**
     * Encodes given JWT
     *
     * @param $jwt JWT
     *
     * @return string
     */
    public function encode(JWT $jwt)
    {
        $this->jwt = $jwt;
        $token     = Codec::encode($jwt->getClaims(), $this->secret);

        return $token;
    }

    /**
     * Decodes given token
     *
     * @param $token
     *
     * @return JWT
     */
    public function decode($token)
    {
        $jwt = new JWT();

        try {
            $decoded = Codec::decode($token, $this->secret, ['HS256']);
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            $jwt->setSignatureValid(false);
        } catch (\Exception $e) {
        }

        list($header, $payload, $signature) = explode(".", $token);
        $header    = base64_decode($header);
        $payload   = json_decode(base64_decode($payload));
        $signature = base64_decode($signature);

        // Retrieves start and end public claims other claims are going to be ignored
        $jwt->setStart(new \DateTime('@'.$payload->nbf));
        $jwt->setEnd(new \Datetime('@'.$payload->exp));

        // Retrieves private claims
        foreach ($payload->data as $key => $value) {
            $jwt->set($key, $value);
        }

        return $jwt;
    }
}
