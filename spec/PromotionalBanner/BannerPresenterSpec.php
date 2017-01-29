<?php

namespace spec\PromotionalBanner;

use PhpSpec\ObjectBehavior;
use PromotionalBanner\Banner;
use PromotionalBanner\BannerRepository;
use Prophecy\Argument;

class BannerPresenterSpec extends ObjectBehavior
{
    private $allowedIps = [
        '10.0.0.1',
        '10.0.0.2',
    ];

    public function let(BannerRepository $bannerRepository)
    {
        $this->beConstructedWith($bannerRepository, $this->allowedIps);
    }

    public function it_returns_all_banners_if_the_client_has_an_allowed_ip(
        BannerRepository $bannerRepository,
        Banner $banner1,
        Banner $banner2
    ) {
        $bannerRepository->findAllBanners()->willReturn([$banner1, $banner2]);
        foreach ($this->allowedIps as $allowedIp) {
            $this->getVisibleBanners($allowedIp)->shouldBe([$banner1, $banner2]);
        }
    }

    public function it_returns_only_banners_in_their_display_period_for_non_allowed_ips(
        BannerRepository $bannerRepository,
        Banner $banner1,
        Banner $banner2
    ) {
        $bannerRepository->findAllBanners()->willReturn([$banner1, $banner2]);
        $banner2->isInDisplayPeriod()->willReturn(true);
        $banner1->isInDisplayPeriod()->willReturn(false);

        $this->getVisibleBanners('10.0.0.4')->shouldBe([$banner2]);
    }
}