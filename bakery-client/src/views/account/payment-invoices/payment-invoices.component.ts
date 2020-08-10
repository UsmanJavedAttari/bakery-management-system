import VueWrapper from '@/components/core/Vue/vue.wrapper';
import { Component } from 'vue-property-decorator';
import { PaymentInvoiceModel, PaymentInvoiceService } from '@/sdk';
import { format } from 'date-fns';

@Component
export default class PaymentInvoicesComponent extends VueWrapper {
  // Propeties
  public PaymentInvoices: Array<PaymentInvoiceModel> = [];

  // Services
  private PaymentInvoiceService = PaymentInvoiceService.Instance;

  // Methods
  public created() {
    this.PaymentInvoiceService.getPaymentInvoices();
    this.PaymentInvoiceService.PaymentInvoices.subscribe(Res => {
      this.PaymentInvoices = Res;
    });
  }
  public formatDate(date: string) {
    return format(new Date(date), 'MMM dd, yyyy hh:mm a');
  }
  public print() {
    window.print();
  }
}
