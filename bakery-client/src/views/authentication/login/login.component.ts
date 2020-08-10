import VueWrapper from '@/components/core/Vue/vue.wrapper';
import { Component } from 'vue-property-decorator';
import {
  LoginModel,
  LoaderService,
  AccountApi,
  CoreService,
  ApiAuth
} from '@/sdk';
import { throwError } from 'rxjs';

@Component
export default class LoginComponent extends VueWrapper {
  // Properties
  public LoginData = new LoginModel();

  // Services
  private ApiAuth = ApiAuth.Instance;
  private LoaderService = LoaderService.Instance;

  // APIs
  private AccountApi = new AccountApi();

  // Methods
  public login() {
    this.LoaderService.showLinearLoader('Logging in...');
    this.AccountApi.login(this.LoginData).subscribe(
      ({ Data }) => {
        this.ApiAuth.Session.next({
          Id: Data.Id,
          DisplayName: Data.DisplayName,
          Email: Data.Email,
          CartId: Data.CartId
        });
        if (this.ApiAuth.save()) {
          this.$router.push({ name: 'Products' });
        } else {
          throw throwError('Unable to login, please try again!');
        }
        this.LoaderService.hideLinearLoader();
      },
      err => {
        CoreService.showAlert(err, 'error');
        this.LoaderService.hideLinearLoader();
      }
    );
  }
}
