<?php

namespace spec\PromotionalBanner;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BannerSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('bannerId');
    }

    public function it_returns_false_if_the_display_period_for_the_banner_isnt_set()
    {
        $this->isInDisplayPeriod()->shouldBe(false);
    }

    public function it_returns_true_if_the_banner_is_in_its_display_period_and_false_if_it_isnt()
    {
        $this->setDisplayPeriod(
            (new \DateTime('-1 day'))->format(\DateTime::ISO8601),
            (new \DateTime('+1 day'))->format(\DateTime::ISO8601)
        );

        $this->isInDisplayPeriod()->shouldBe(true);

        $this->setDisplayPeriod(
            (new \DateTime('-2 day'))->format(\DateTime::ISO8601),
            (new \DateTime('-1 day'))->format(\DateTime::ISO8601)
        );

        $this->isInDisplayPeriod()->shouldBe(false);
    }

    public function it_validates_that_the_display_period_is_well_defined_using_iso8601_strings_as_inputs()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->duringSetDisplayPeriod(
            (new \DateTime('-1 day'))->format(\DateTime::RFC822),
            (new \DateTime('+1 day'))->format(\DateTime::RFC822)
        );

        $this->shouldThrow(\InvalidArgumentException::class)->duringSetDisplayPeriod(
            (new \DateTime('-1 day'))->format(\DateTime::ISO8601),
            (new \DateTime('-2 day'))->format(\DateTime::ISO8601)
        );
    }
}