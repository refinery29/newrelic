<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\NewRelic;

trait AgentAwareTrait
{
    /**
     * @var AgentInterface
     */
    protected $agent;

    public function setAgent(AgentInterface $agent)
    {
        $this->agent = $agent;
    }
}
