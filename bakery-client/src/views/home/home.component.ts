import VueWrapper from '@/components/core/Vue/vue.wrapper';
import { Component } from 'vue-property-decorator';
import { ApiAuth } from '@/sdk';

@Component
export default class HomeComponent extends VueWrapper {
  // Properties
  public ContactDetails = [
    {
      Title: 'Customer Support',
      Value: '+1 234 56 7894'
    },
    {
      Title: 'Email Address',
      Value: 'info@gmail.com'
    },
    {
      Title: 'Office Address',
      Value: '4461 Cedar Street Moro, AR 72368'
    },
    {
      Title: 'Office Time',
      Value: '9:00AM To 6:00PM'
    }
  ];

  // Services
  private ApiAuth = ApiAuth.Instance;
}
