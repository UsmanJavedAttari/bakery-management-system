export class PaymentInvoiceModel {
  public Id: string | null = null;
  public OrderId: string | null = null;
  public AmountCharged: string | null = null;
  public PaymentCardNumber: string | null = null;
  public GeneratedAt: string | null = null;

  constructor(data?: Partial<PaymentInvoiceModel>) {
    Object.assign(this, data);
  }
}
