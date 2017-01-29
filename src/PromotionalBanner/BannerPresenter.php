<?php

namespace PromotionalBanner;

class BannerPresenter
{
    /**
     * @var BannerRepository
     */
    private $bannerRepository;
    /**
     * @var array
     */
    private $allowedIps;

    public function __construct(BannerRepository $bannerRepository, array $allowedIps)
    {
        $this->bannerRepository = $bannerRepository;
        $this->allowedIps = $allowedIps;
    }

    /**
     * @param string $clientIp
     * @return Banner[]
     */
    public function getVisibleBanners($clientIp)
    {
        if (in_array($clientIp, $this->allowedIps)) {
            return $this->bannerRepository->findAllBanners();
        }

        return array_values(array_filter($this->bannerRepository->findAllBanners(), function (Banner $banner) {
            return $banner->isInDisplayPeriod();
        }));
    }
}