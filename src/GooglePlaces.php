<?php

namespace BBSLab\NovaGooglePlacesField;

use Laravel\Nova\Fields\Field;

class GooglePlaces extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-google-places-field';

    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this
            ->displayAddress('display_address')
            ->city('city')
            ->state('state')
            ->postalCode('postal_code')
            ->country('country')
            ->latitude('latitude')
            ->longitude('longitude');
    }

    /**
     * Instruct the field to only display cities in its results.
     *
     * @return $this
     */
    public function onlyCities(): GooglePlaces
    {
        return $this->type('(cities)');
    }

    /**
     * Set the place type.
     *
     * @param  string  $type
     * @return $this
     */
    public function type(string $type): GooglePlaces
    {
        if ($type == '(cities)') {
            $this->city(null)->postalCode(null);
        }

        return $this->withMeta(['placeType' => $type]);
    }

    /**
     * Set the countries to search within.
     *
     * @param  array  $countries
     * @return $this
     */
    public function countries(array $countries): GooglePlaces
    {
        return $this->withMeta(['countries' => $countries]);
    }

    /**
     * Specify the field that contains the display address.
     *
     * @param  string  $field
     * @return $this
     */
    public function displayAddress($field): GooglePlaces
    {
        return $this->withMeta([__FUNCTION__ => $field]);
    }

    /**
     * Specify the field that contains the city.
     *
     * @param  string  $field
     * @return $this
     */
    public function city($field): GooglePlaces
    {
        return $this->withMeta([__FUNCTION__ => $field]);
    }

    /**
     * Specify the field that contains the state.
     *
     * @param  string  $field
     * @return $this
     */
    public function state($field): GooglePlaces
    {
        return $this->withMeta([__FUNCTION__ => $field]);
    }

    /**
     * Specify the field that contains the postal code.
     *
     * @param  string  $field
     * @return $this
     */
    public function postalCode($field): GooglePlaces
    {
        return $this->withMeta([__FUNCTION__ => $field]);
    }

    /**
     * Specify the field that contains the country.
     *
     * @param  string  $field
     * @return $this
     */
    public function country($field): GooglePlaces
    {
        return $this->withMeta([__FUNCTION__ => $field]);
    }

    /**
     * Specify the field that contains the latitude.
     *
     * @param  string  $field
     * @return $this
     */
    public function latitude($field): GooglePlaces
    {
        return $this->withMeta([__FUNCTION__ => $field]);
    }

    /**
     * Specify the language that places.js should use.
     *
     * @param  string  $language
     * @return $this
     */
    public function language($language): GooglePlaces
    {
        return $this->withMeta([__FUNCTION__ => $language]);
    }

    /**
     * Specify the field that contains the longitude.
     *
     * @param  string  $field
     * @return $this
     */
    public function longitude($field): GooglePlaces
    {
        return $this->withMeta([__FUNCTION__ => $field]);
    }
}
