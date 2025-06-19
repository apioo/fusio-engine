<?php
/*
 * Fusio - Self-Hosted API Management for Builders.
 * For the current version and information visit <https://www.fusio-project.org/>
 *
 * Copyright (c) Christoph Kappestein <christoph.kappestein@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Fusio\Engine\Payment;

/**
 * CheckoutContext
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class CheckoutContext
{
    private string $returnUrl;
    private string $cancelUrl;
    private string $currency;
    private ?string $domain;

    public function __construct(string $returnUrl, string $cancelUrl, string $currency, ?string $domain = null)
    {
        $this->returnUrl = $returnUrl;
        $this->cancelUrl = $cancelUrl;
        $this->currency = $currency;
        $this->domain = $domain;
    }

    public function getReturnUrl(): string
    {
        return $this->returnUrl;
    }

    public function getCancelUrl(): string
    {
        return $this->cancelUrl;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }
}
