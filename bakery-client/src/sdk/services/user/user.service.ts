import { BehaviorSubject } from 'rxjs';
import { AccountApi } from '@/sdk/api-services';
import { LoaderService } from '../shared/loader.service';
import { CoreService } from '../shared/core.service';
import { PaymentAccountModel } from '@/sdk/models';

export class UserService {
  private static _Instance: UserService;
  public static get Instance() {
    if (!this._Instance) {
      this._Instance = new UserService();
    }
    return this._Instance;
  }
  private constructor() {}

  // Services
  private LoaderService = LoaderService.Instance;

  // APIs
  private AccountApi = new AccountApi();

  // Payment Accounts
  public PaymentAccounts = new BehaviorSubject<Array<PaymentAccountModel>>([]);
  public getPaymentAccounts() {
    this.LoaderService.showFullScreenLoader();
    this.AccountApi.getPaymentAccounts().subscribe(
      ({ Data }) => {
        this.PaymentAccounts.next(Data);
        this.LoaderService.hideFullScreenLoader();
      },
      err => {
        this.LoaderService.hideFullScreenLoader();
        CoreService.showAlert(err, 'error');
      }
    );
  }

  // Remove Payment Account
  public removePaymentAccount(PaymentCardNumber: string) {
    this.LoaderService.showFullScreenLoader();
    this.AccountApi.removePaymentAccount(PaymentCardNumber).subscribe(
      () => {
        this.getPaymentAccounts();
        CoreService.showAlert(
          'Payment Account has been removed successfully!',
          'success'
        );
        this.LoaderService.hideFullScreenLoader();
      },
      err => {
        CoreService.showAlert(err, 'error');
        this.LoaderService.hideFullScreenLoader();
      }
    );
  }

  // Add Payment Account
  public addPaymentAccount(PaymentCardNumber: string) {
    this.LoaderService.showFullScreenLoader();
    this.AccountApi.addPaymentAccount(PaymentCardNumber).subscribe(
      () => {
        this.getPaymentAccounts();
        CoreService.showAlert(
          'Payment Account has been added successfully!',
          'success'
        );
        this.LoaderService.hideFullScreenLoader();
      },
      err => {
        CoreService.showAlert(err, 'error');
        this.LoaderService.hideFullScreenLoader();
      }
    );
  }
}
