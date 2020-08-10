import VueWrapper from '@/components/core/Vue/vue.wrapper';
import { Component } from 'vue-property-decorator';
import { SignupModel, LoaderService, AccountApi, CoreService } from '@/sdk';

@Component
export default class SignupComponent extends VueWrapper {
  // Properties
  public SignupData = new SignupModel();

  // Services
  private LoaderService = LoaderService.Instance;

  // APIs
  private AccountApi = new AccountApi();

  // Methods
  public signup() {
    this.LoaderService.showLinearLoader('Signing up...');
    this.AccountApi.signup(this.SignupData).subscribe(
      () => {
        this.$router.push({ name: 'Login' });
        this.LoaderService.hideLinearLoader();
      },
      err => {
        this.LoaderService.hideLinearLoader();
        CoreService.showAlert(err, 'error');
      }
    );
  }
}
