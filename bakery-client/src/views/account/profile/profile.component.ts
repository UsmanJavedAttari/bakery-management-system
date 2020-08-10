import VueWrapper from '@/components/core/Vue/vue.wrapper';
import { Component } from 'vue-property-decorator';
import {
  ApiAuth,
  AccountApi,
  SignupModel,
  LoaderService,
  CoreService,
  SessionModel,
  PaymentAccountModel,
  UserService
} from '@/sdk';
import BaseFormComponent from '@/components/vuetify/Form/base-form';

@Component
export default class ProfileComponent extends VueWrapper {
  // Refs
  public $refs!: {
    paymentAccountFormRef: BaseFormComponent;
  };

  // Properties
  public DisplayName = ApiAuth.Instance.SessionValue?.DisplayName;
  public Password: string | null = null;
  public PaymentCardNumber: string | null = null;
  public PaymentAccounts: Array<PaymentAccountModel> = [];

  // Services
  private LoaderService = LoaderService.Instance;
  private UserService = UserService.Instance;

  // Methods
  public updateProfile() {
    this.LoaderService.showFullScreenLoader();
    const user: Partial<SignupModel> = {
      DisplayName: this.DisplayName
    };
    if (!!this.Password) {
      user.Password = this.Password;
    }
    new AccountApi().updateUser(user).subscribe(
      () => {
        this.LoaderService.hideFullScreenLoader();
        ApiAuth.Instance.Session.next(
          new SessionModel({
            ...ApiAuth.Instance.Session.value,
            DisplayName: this.DisplayName
          })
        );
        ApiAuth.Instance.save();
        CoreService.showAlert('Profile updated successfully!', 'success');
      },
      err => {
        CoreService.showAlert(err, 'error');
        this.LoaderService.hideFullScreenLoader();
      }
    );
  }
  public created() {
    this.UserService.getPaymentAccounts();
    this.UserService.PaymentAccounts.subscribe(Res => {
      this.PaymentAccounts = Res;
    });
  }
  public addPaymentAccount() {
    if (!!this.PaymentCardNumber) {
      this.UserService.addPaymentAccount(this.PaymentCardNumber);
      this.PaymentCardNumber = null;
      this.$refs.paymentAccountFormRef.reset();
    }
  }
}
