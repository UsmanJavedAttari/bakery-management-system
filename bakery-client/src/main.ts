import Vue from 'vue';
import router from './router';
import vuetify from './plugins/vuetify';
import AppComponent from './app.component';
import { SdkConfig } from './sdk/sdk.config';

import './components';
import './plugins';

SdkConfig.ApiPath = 'http://localhost/bakery-api';

Vue.config.productionTip = false;

new Vue({
  router,
  vuetify,
  render: h => h(AppComponent)
}).$mount('#app');
