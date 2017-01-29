<?php

namespace PromotionalBanner;

class Banner
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var \DateTime|null
     */
    private $displayFrom;
    /**
     * @var \DateTime|null
     */
    private $displayTo;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $from
     * @param string $to
     */
    public function setDisplayPeriod($from, $to)
    {
        $fromDateTime = \DateTime::createFromFormat(\DateTime::ISO8601, $from);

        if (!$fromDateTime) {
            throw new \InvalidArgumentException(sprintf(
                "Invalid time format for \"from\" parameter. Expected a valid ISO8601 string, got %s.",
                $from
            ));
        }

        $toDateTime = \DateTime::createFromFormat(\DateTime::ISO8601, $to);

        if (!$toDateTime) {
            throw new \InvalidArgumentException(sprintf(
                "Invalid time format for \"to\" parameter. Expected a valid ISO8601 string, got %s.",
                $to
            ));
        }

        if ($fromDateTime >= $toDateTime) {
            throw new \InvalidArgumentException("The period must start before the end date.");
        }

        $this->displayFrom = $fromDateTime;
        $this->displayTo = $toDateTime;
    }

    /**
     * @return bool
     */
    public function isInDisplayPeriod()
    {
        $now = new \DateTime();
        return $this->displayTo instanceof \DateTime
            && $this->displayFrom instanceof \DateTime
            && $now > $this->displayFrom
            && $now < $this->displayTo
        ;
    }
}