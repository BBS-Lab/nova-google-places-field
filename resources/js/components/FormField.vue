<template>
  <default-field :field="field" :errors="errors" :show-help-text="showHelpText">
    <template slot="field">
      <input
        :ref="field.attribute"
        :id="field.attribute"
        type="text"
        v-model="value"
        class="w-full form-control form-input form-input-bordered"
        :class="errorClasses"
        :placeholder="field.name"
        :disabled="isReadonly"
      />
    </template>
  </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'resourceId', 'field'],

  data: () => ({
    places: null,
    address_components: null,
  }),

  mounted() {
    this.setInitialValue()

    // Add a default fill method for the field
    this.field.fill = this.fill

    // Register a global event for setting the field's value
    Nova.$on(this.field.attribute + '-value', value => {
      this.value = value
    })

    this.initializePlaces()
  },

  methods: {
    initializePlaces() {
      console.log(this.field)
      const config = {
        fields: ['address_components', 'geometry', 'name'],
        types: [this.field.placeType ? this.field.placeType : 'address'],
      }

      if (this.field.countries) {
        config.componentRestrictions = {
          country: this.field.countries
        }
      }
      console.log(config)
      const placesAutocomplete = new google.maps.places.Autocomplete(
        this.$refs[this.field.attribute], config
      )

      placesAutocomplete.addListener('place_changed', () => {
        this.$nextTick(() => {
          let place = placesAutocomplete.getPlace()
          this.address_components = place.address_components

          let {
            administrative_area_level_1,
            administrative_area_level_2,
            country,
            locality,
            postal_code,
            route,
            street_number,
          } = this.parseAddressComponent(this.address_components)
          this.value = `${street_number.long_name} ${route.long_name}`
          let display = `${this.value}, ${postal_code.long_name} ${locality.long_name}, ${country.long_name}`

          Nova.$emit(this.field.displayAddress + '-value', display)
          Nova.$emit(this.field.city + '-value', locality.long_name)
          Nova.$emit(this.field.state + '-value', administrative_area_level_1.long_name)
          Nova.$emit(this.field.postalCode + '-value', postal_code.long_name)
          Nova.$emit(this.field.country + '-value', country.short_name)
          Nova.$emit(this.field.latitude + '-value', place.geometry.location.lat())
          Nova.$emit(this.field.longitude + '-value', place.geometry.location.lng())
        })
      })
    },

    parseAddressComponent(address) {
      return address.reduce((carry, value) => {
        carry[value.types[0]] = { long_name: value.long_name, short_name: value.short_name}
        return carry
      }, {})
    },

    fill(formData) {
      formData.append(this.field.attribute, String(this.value))
      formData.append(this.field.attribute + '__components', this.address_components)
    },
  },
}
</script>
