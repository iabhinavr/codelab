const path = require('path');

module.exports = {
  entry: {
    './js/dist/basic-alert.js' : './js/basic-alert.js',
    './js/dist/profile-page-form.js' : './js/profile-page-form.js',
    './js/dist/show-booking-1.js' : './js/show-booking-1.js',
    './js/dist/show-booking-2.js' : './js/show-booking-2.js',
    './js/dist/login.js' : './js/login.js'
  },
  output: {
    filename: '[name]',
    path: path.resolve(__dirname),
  },
  mode: 'development',
    watch: true,
    watchOptions: {
        aggregateTimeout: 1000,
        poll: 1000
    },
};