<?php
/**
 * Copyright (c) 2018 Matthias Morin <matthias.morin@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace TangoMan\JWTBundle\Model;

/**
 * Class JWT
 * JSON Web Tokens are an open, industry standard RFC 7519 method for
 * representing claims securely between two parties. https://jwt.io/
 * https://tools.ietf.org/html/rfc7519#section-4.1
 *
 * @package TangoMan\JWTBundle\Model
 */
class JWT
{

    /**
     * @var array
     */
    private $claims;

    /**
     * @var bool
     */
    private $signatureValid;

    /**
     * JWT constructor.
     */
    public function __construct()
    {
        $this->claims         = [];
        $this->signatureValid = true;
    }


    /******************
     * Private claims *
     *****************/

    /**
     * Set token private claim
     *
     * @param $key
     * @param $value
     *
     * @return JWT
     */
    public function set($key, $value)
    {
        $this->claims['data'][$key] = $value;

        return $this;
    }

    /**
     * Get token private claim
     *
     * @return array
     */
    public function get($key)
    {
        //        return $this->claims['data'][$key] ?? null;

        if (isset($this->claims['data'][$key])) {
            return $this->claims['data'][$key];
        } else {
            return null;
        }
    }

    /**
     * Removes token private claim
     *
     * @param $key
     *
     * @return JWT
     */
    public function remove($key)
    {
        unset($this->claims['data'][$key]);

        return $this;
    }

    /**
     * Returns public and private claims
     *
     * @return array
     */
    public function getClaims()
    {
        return $this->claims;
    }


    /***************************
     * Expiration and validity *
     **************************/

    /**
     * Sets token expiration period
     *
     * @param \DateTime|null $start
     * @param \DateTime|null $end
     *
     * @return JWT
     */
    public function setPeriod(\DateTime $start = null, \DateTime $end = null)
    {
        $this->claims['nbf'] = $start->getTimestamp();
        $this->claims['exp'] = $end->getTimestamp();

        return $this;
    }

    /**
     * Set token starting validity from timestamp
     *
     * @param \DateTime $start
     *
     * @return $this
     */
    public function setStart(\DateTime $start)
    {
        $this->claims['nbf'] = $start->getTimestamp();

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return new \DateTime('@'.$this->claims['nbf']);
    }

    /**
     * Set token expiration from timestamp
     *
     * @param \DateTime $end
     *
     * @return $this
     */
    public function setEnd(\DateTime $end)
    {
        $this->claims['exp'] = $end->getTimestamp();

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return new \DateTime("@".$this->claims['exp']);
    }


    /**************
     * Validation *
     *************/

    /**
     * Set signatureValid
     *
     * @param boolean $signatureValid
     *
     * @return JWT
     */
    public function setSignatureValid($signatureValid)
    {
        $this->signatureValid = $signatureValid;

        return $this;
    }

    /**
     * Get signatureValid
     *
     * @return bool
     */
    public function getSignatureValid()
    {
        return $this->signatureValid;
    }

    /**
     * Checks for signature
     *
     * @return bool
     */
    public function isSignatureValid()
    {
        return $this->signatureValid;
    }

    /**
     * Checks for before valid
     *
     * @return bool
     */
    public function isTooSoon()
    {
        return new \DateTime < new \DateTime("@".$this->claims['nbf']);
    }

    /**
     * Check for expiration
     *
     * @return bool
     */
    public function isTooLate()
    {
        return new \DateTime > new \DateTime("@".$this->claims['exp']);
    }

    /**
     * Check for expiration
     *
     * @return bool
     */
    public function isOnTime()
    {
        return ! $this->isTooSoon() && ! $this->isTooLate();
    }

    /**
     * Checks for global token validity
     *
     * @return bool
     */
    public function isValid()
    {
        return $this->isOnTime() && $this->isSignatureValid();
    }
}

