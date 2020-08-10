export class SignupModel {
  public DisplayName: string | null = null;
  public Email: string | null = null;
  public Password: string | null = null;
  public PaymentCardNumber: string | null = null;

  constructor(data?: Partial<SignupModel>) {
    Object.assign(this, data);
  }
}
