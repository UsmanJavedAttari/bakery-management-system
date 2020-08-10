import { BaseApi } from '../base.api';
import { Observable } from 'rxjs';
import { PaymentInvoiceModel } from '@/sdk/models';

export class PaymentInvoiceApi extends BaseApi {
  public getPaymentInvoices(): Observable<ApiRes<Array<PaymentInvoiceModel>>> {
    return this.GET_Request(
      `${this.ApiUrl}/paymentinvoice/read.php?customerId=${this.ApiAuth.SessionValue?.Id}`
    );
  }
}
