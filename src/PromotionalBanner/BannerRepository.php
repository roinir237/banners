<?php

namespace PromotionalBanner;

class BannerRepository
{
    private $bannerCache = [
        ['banner1', '2017-01-01T12:00:00+0900', '2017-03-10T12:00:00+0900'],
        ['banner2', '2017-01-10T12:00:00+0900', '2017-03-10T12:00:00+0900']
    ];

    /**
     * @return Banner[]
     */
    public function findAllBanners()
    {
        return array_map([$this, 'mapDataRowToBanner'], $this->bannerCache);
    }

    private function mapDataRowToBanner(array $row)
    {
        $banner = new Banner($row[0]);
        $banner->setDisplayPeriod($row[1], $row[2]);
        return $banner;
    }
}