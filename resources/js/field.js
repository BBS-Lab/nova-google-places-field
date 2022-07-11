Nova.booting((Vue, router, store) => {
  Vue.component('index-nova-google-places-field', require('./components/IndexField'))
  Vue.component('detail-nova-google-places-field', require('./components/DetailField'))
  Vue.component('form-nova-google-places-field', require('./components/FormField'))
})
