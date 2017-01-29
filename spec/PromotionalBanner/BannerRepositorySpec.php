<?php

namespace spec\PromotionalBanner;

use PhpSpec\ObjectBehavior;
use PromotionalBanner\Banner;
use Prophecy\Argument;

class BannerRepositorySpec extends ObjectBehavior
{
    public function it_returns_a_list_of_banners()
    {
        foreach ($this->findAllBanners() as $banner) {
            $banner->shouldBeAnInstanceOf(Banner::class);
        }
    }
}