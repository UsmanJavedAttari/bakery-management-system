import { BaseApi } from '../base.api';
import {
  LoginModel,
  SessionModel,
  SignupModel,
  PaymentAccountModel
} from '@/sdk/models';
import { Observable } from 'rxjs';

export class AccountApi extends BaseApi {
  public login(loginData: LoginModel): Observable<ApiRes<SessionModel>> {
    return this.POST_Request(`${this.ApiUrl}/customer/login.php`, loginData);
  }
  public signup(signupData: SignupModel): Observable<ApiRes> {
    return this.POST_Request(`${this.ApiUrl}/customer/signup.php`, signupData);
  }
  public updateUser(user: Partial<SignupModel>): Observable<ApiRes> {
    return this.POST_Request(`${this.ApiUrl}/customer/update.php`, {
      ...user,
      Id: this.ApiAuth.SessionValue?.Id
    });
  }
  public getPaymentAccounts(): Observable<ApiRes<Array<PaymentAccountModel>>> {
    return this.GET_Request(
      `${this.ApiUrl}/paymentaccount/read.php?CustomerId=${this.ApiAuth.SessionValue?.Id}`
    );
  }
  public removePaymentAccount(PaymentCardNumber: string): Observable<ApiRes> {
    return this.DELETE_Request(
      `${this.ApiUrl}/paymentaccount/remove.php?PaymentCardNumber=${PaymentCardNumber}`
    );
  }
  public addPaymentAccount(PaymentCardNumber: string): Observable<ApiRes> {
    return this.POST_Request(`${this.ApiUrl}/paymentaccount/create.php`, {
      PaymentCardNumber,
      CustomerId: this.ApiAuth.SessionValue?.Id
    } as PaymentAccountModel);
  }
}
