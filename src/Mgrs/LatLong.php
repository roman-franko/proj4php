<?php

namespace Academe\Proj4Php\Mgrs;

/**
 * Lat/long concrete.
 */

class LatLong implements LatLongInterface {
    /**
     * The latitude of the coordinate.
     *
     * @var double
     */

    protected $latitude;

    /**
     * The longitude of the coordinate.
     *
     * @var double
     */

    protected $longitude;

    /**
     * {@inheritDoc}
     */

    public function normalizeLatitude($latitude) {
        return (double)max(-90, min(90, $latitude));
    }

    /**
     * {@inheritDoc}
     */

    public function normalizeLongitude($longitude) {
        if (180 === fmod($longitude, 360)) {
            return 180.0;
        }

        $mod = fmod($longitude, 360);
        $longitude = $mod < -180 ? $mod + 360 : ($mod > 180 ? $mod - 360 : $mod);

        return (double)$longitude;
    }

    /**
     * {@inheritDoc}
     */

    public function setLatitude($latitude) {
        $this->latitude = $this->normalizeLatitude($latitude);
    }

    /**
     * {@inheritDoc}
     */

    public function getLatitude() {
        return $this->latitude;
    }

    /**
     * {@inheritDoc}
     */

    public function setLongitude($longitude) {
        $this->longitude = $this->normalizeLongitude($longitude);
    }

    /**
     * {@inheritDoc}
     */

    public function getLongitude() {
        return $this->longitude;
    }

    /**
     * Constructor to set values.
     * @todo Do we want to support named element keys, e.g. 'lat' and 'lon'?
     */
    public function __construct($latitude, $longitude = null) {
        if (!isset($longitude) && is_array($latitude) && count($latitude) == 2) {
            // The order of the elements is latitude then longitude.
            list($lat, $long) = array_values($latitude);
            $this->setLatitude($lat);
            $this->setLongitude($long);
        } elseif (isset($longitude)) {
            $this->setLatitude($latitude);
            $this->setLongitude($longitude);
        } else {
            throw new InvalidArgumentException(
                'Coordinate should be a an array; %s passed instead', gettype($coordinates)
            );
        }
    }
}
