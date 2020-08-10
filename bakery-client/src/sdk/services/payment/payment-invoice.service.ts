import { BehaviorSubject } from 'rxjs';
import { PaymentInvoiceModel } from '@/sdk/models';
import { PaymentInvoiceApi } from '@/sdk/api-services';
import { LoaderService } from '../shared/loader.service';
import { CoreService } from '../shared/core.service';

export class PaymentInvoiceService {
  private static _Instance: PaymentInvoiceService;
  public static get Instance() {
    if (!this._Instance) {
      this._Instance = new PaymentInvoiceService();
    }
    return this._Instance;
  }
  private constructor() {}

  // Services
  private LoaderService = LoaderService.Instance;

  // APIs
  private PaymentInvoiceApi = new PaymentInvoiceApi();

  // PaymentInvoice Categories

  // PaymentInvoice Categories
  public PaymentInvoices = new BehaviorSubject<Array<PaymentInvoiceModel>>([]);
  public getPaymentInvoices(loaderState = true) {
    this.LoaderService.showFullScreenLoader(undefined, loaderState);
    this.PaymentInvoiceApi.getPaymentInvoices().subscribe(
      ({ Data }) => {
        this.LoaderService.hideFullScreenLoader(loaderState);
        this.PaymentInvoices.next(Data);
      },
      () => {
        this.LoaderService.hideFullScreenLoader(loaderState);
        CoreService.showAlert('Unable to load products', 'error');
      }
    );
  }
}
