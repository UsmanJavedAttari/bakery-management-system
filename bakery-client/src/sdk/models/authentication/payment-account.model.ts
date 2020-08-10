export class PaymentAccountModel {
  public PaymentCardNumber: string | null = null;
  public CustomerId: string | null = null;

  constructor(data?: Partial<PaymentAccountModel>) {
    Object.assign(this, data);
  }
}
