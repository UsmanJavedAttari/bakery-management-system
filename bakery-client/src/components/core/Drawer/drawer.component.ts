import { Component } from 'vue-property-decorator';
import VueWrapper from '../Vue/vue.wrapper';
import { CoreService, ApiAuth } from '@/sdk';

@Component
export default class DrawerComponent extends VueWrapper {
  // Properties
  public DrawerLinks = [
    { Title: 'Home', Icon: 'mdi-home-outline' },
    { Title: 'Products', Icon: 'mdi-package-variant' },
    { Title: 'Payment Invoices', Icon: 'mdi-file-document-outline' },
    { Title: 'Profile', Icon: 'mdi-account-outline' }
  ];

  // Services
  private CoreService = CoreService.Instance;
  private ApiAuth = ApiAuth.Instance;
}
